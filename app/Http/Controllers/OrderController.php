<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Theme;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\QrisService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected $orderService;
    protected $qrisService;

    public function __construct(OrderService $orderService, QrisService $qrisService)
    {
        $this->orderService = $orderService;
        $this->qrisService = $qrisService;
    }

    public function create()
    {
        $themes = Theme::where('is_active', true)->get();
        return view('order.form', compact('themes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slug'            => 'required|alpha_dash|unique:invitations,slug',
            'theme_id'        => 'required|exists:themes,id',
            'client_whatsapp' => ['required', 'regex:/^\+?[0-9]{9,15}$/'],
            'groom_name'      => 'required|string|max:255',
            'bride_name'      => 'required|string|max:255',
            'event_date'      => 'required|date|after_or_equal:today',
        ]);

        $whatsapp = $request->client_whatsapp;
        if (str_starts_with($whatsapp, '+')) {
            $whatsapp = substr($whatsapp, 1);
        }
        if (str_starts_with($whatsapp, '0')) {
            $whatsapp = '62' . substr($whatsapp, 1);
        } elseif (str_starts_with($whatsapp, '8')) {
            $whatsapp = '62' . $whatsapp;
        }

        $generatedEmail = $request->slug . '@temanten.biz.id';

        if (User::where('email', $generatedEmail)->exists()) {
            return back()->withErrors(['slug' => 'ID Login untuk link ini sudah terdaftar. Mohon ganti link undangan.'])->withInput();
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $request->groom_name . ' & ' . $request->bride_name,
                'email'    => $generatedEmail,
                'password' => Hash::make(Str::random(10)),
                'role'     => 'client',
            ]);

            // User created, wait for admin to approve and send the real credentials.
            // \Illuminate\Support\Facades\Auth::login($user); // Auto-login removed.

            $theme = Theme::findOrFail($request->theme_id);
            $basePrice = $this->orderService->calculatePrice($theme);
            $uniqueCode = $this->orderService->generateUniqueCode();
            $totalAmount = $basePrice - $uniqueCode;

            $order = Order::create([
                'order_number' => $this->orderService->generateOrderNumber(),
                'theme_id'     => $theme->id,
                'user_id'      => $user->id,
                'unique_code'  => $uniqueCode,
                'total_amount' => $totalAmount,
                'status'       => 'pending',
                'expired_at'   => Carbon::now()->addHours(2),
            ]);

            $content = [
                'mempelai' => [
                    'pria' => [
                        'nama'      => $request->groom_name,
                        'panggilan' => explode(' ', $request->groom_name)[0],
                        'ayah'      => 'Bpk. (Nama Ayah Pria)',
                        'ibu'       => 'Ibu (Nama Ibu Pria)',
                        'foto'      => null
                    ],
                    'wanita' => [
                        'nama'      => $request->bride_name,
                        'panggilan' => explode(' ', $request->bride_name)[0],
                        'ayah'      => 'Bpk. (Nama Ayah Wanita)',
                        'ibu'       => 'Ibu (Nama Ibu Wanita)',
                        'foto'      => null
                    ]
                ],
                'acara' => [
                    'akad' => [
                        'judul'   => 'Akad Nikah',
                        'waktu'   => $request->event_date . ' 08:00:00',
                        'tempat'  => 'Lokasi Akad',
                        'alamat'  => 'Alamat lengkap lokasi akad...',
                        'maps'    => null
                    ],
                    'resepsi' => [
                        'judul'   => 'Resepsi Pernikahan',
                        'waktu'   => $request->event_date . ' 11:00:00',
                        'tempat'  => 'Lokasi Resepsi',
                        'alamat'  => 'Alamat lengkap lokasi resepsi...',
                        'maps'    => null
                    ]
                ],
                'media' => [
                    'cover'      => null,
                    'music'      => null,
                    'video_link' => null,
                    'gallery'    => []
                ],
                'amplop' => [
                    'bank_name'      => 'BCA',
                    'account_number' => '1234567890',
                    'account_holder' => $request->groom_name,
                    'alamat_kado'    => 'Alamat rumah mempelai...'
                ],
                'love_stories' => [],
                'quote'        => 'Kami mengundang Anda untuk merayakan pernikahan kami.'
            ];

            Invitation::create([
                'uuid'            => (string) Str::uuid(),
                'user_id'         => $user->id,
                'theme_id'        => $request->theme_id,
                'slug'            => $request->slug,
                'title'           => 'The Wedding of ' . $request->groom_name . ' & ' . $request->bride_name,
                'event_date'      => $request->event_date,
                'status'          => 'pending',
                'client_whatsapp' => $whatsapp,
                'content'         => $content
            ]);

            DB::commit();

            return redirect()->route('order.payment')->with([
                'success'      => 'Pesanan berhasil dibuat!',
                'order_number' => $order->order_number,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create order: ' . $e->getMessage());
            return back()->withErrors(['msg' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'])->withInput();
        }
    }

    public function payment()
    {
        $orderNumber = session('order_number');

        if (!$orderNumber) {
            return redirect()->route('order.create');
        }

        $order = Order::with(['theme', 'user'])->where('order_number', $orderNumber)->firstOrFail();

        $masterQris = config('temanten.qris_master_string', '00020101021226610014COM.GO-JEK.WWW01189360091431720318940210G1720318940303UMI51440014ID.CO.QRIS.WWW0215ID10254220360590303UMI520456915303360540410005802ID5908Temanten6008PEMALANG61055235262070703A016304B3D8');
        
        $order->dynamic_qris = $this->qrisService->generateDynamic($masterQris, $order->total_amount);

        return view('order.payment', compact('order'));
    }
}
