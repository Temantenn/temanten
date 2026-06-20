<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\User;
use App\Models\Theme;
use App\Models\Order;
use App\Services\OrderService;
use App\Services\QrisService;
use App\Support\WhatsAppNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
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
            'slug'            => ['required', 'alpha_dash', 'not_regex:/^demo(?:-|$)/i', 'unique:invitations,slug'],
            'theme_id'        => 'required|exists:themes,id',
            'client_whatsapp' => [
                'required',
                'string',
                'max:30',
                WhatsAppNumber::validationRule('Nomor WhatsApp pemesan tidak valid. Gunakan nomor Indonesia aktif, contoh: 081234567890.'),
            ],
            'groom_name'      => 'required|string|max:255',
            'bride_name'      => 'required|string|max:255',
            'event_date'      => 'required|date|after_or_equal:today',
        ]);

        $whatsapp = WhatsAppNumber::normalize($request->client_whatsapp);

        if ($whatsapp === null) {
            return back()->withErrors([
                'client_whatsapp' => 'Nomor WhatsApp pemesan tidak valid. Gunakan nomor Indonesia aktif, contoh: 081234567890.',
            ])->withInput();
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

            $theme = Theme::findOrFail($request->theme_id);
            $basePrice = $this->orderService->calculatePrice($theme);

            $order = $this->orderService->createOrderWithUniqueCode([
                'order_number' => $this->orderService->generateOrderNumber(),
                'theme_id'     => $theme->id,
                'user_id'      => $user->id,
                'status'       => 'pending',
                'expired_at'   => Carbon::now()->addHours(2),
            ], $basePrice);

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

        } catch (QueryException $e) {
            DB::rollBack();

            if ($this->isDuplicateSlugOrLogin($e)) {
                return back()->withErrors(['slug' => 'Link undangan atau ID Login sudah terdaftar. Mohon ganti link undangan.'])->withInput();
            }

            Log::error('Failed to create order: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['msg' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'])->withInput();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create order: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['msg' => 'Terjadi kesalahan sistem. Silakan coba lagi nanti.'])->withInput();
        }
    }

    private function isDuplicateSlugOrLogin(QueryException $e): bool
    {
        $message = $e->getMessage();
        $sqlState = (string) ($e->errorInfo[0] ?? '');

        if (!in_array($sqlState, ['23000', '23505'], true) && !str_contains($message, 'UNIQUE constraint failed')) {
            return false;
        }

        return str_contains($message, 'users_email_unique')
            || str_contains($message, 'users.email')
            || str_contains($message, 'invitations_slug_unique')
            || str_contains($message, 'invitations.slug');
    }

    public function payment()
    {
        $orderNumber = session('order_number');

        if (!$orderNumber) {
            // Session lost (cookie blocked? or user opened /pembayaran directly).
            // Send them to form with a clear message instead of silent redirect loop.
            return redirect()->route('order.create')->withErrors([
                'msg' => 'Sesi pesanan tidak ditemukan. Silakan buat pesanan ulang.',
            ]);
        }

        $order = Order::with(['theme', 'user'])->where('order_number', $orderNumber)->firstOrFail();

        $masterQris = config('temanten.qris_master_string');

        if (!$masterQris) {
            Log::warning('QRIS master string not configured', [
                'order_number' => $orderNumber,
                'env_QRIS_MASTER_STRING_set' => env('QRIS_MASTER_STRING') !== null && env('QRIS_MASTER_STRING') !== '',
            ]);
            // Redirect to order create (NOT back()) to avoid potential redirect loop.
            return redirect()->route('order.create')->withErrors([
                'msg' => 'Pembayaran sedang diproses. Silakan hubungi admin jika masalah berlanjut.',
            ]);
        }

        // Nominal di QR = total_amount (harga flat) + unique_code (suffix verifikasi).
        // User melihat harga flat; unique_code otomatis ditambahkan saat generate QR.
        $qrisAmount = $order->total_amount + $order->unique_code;
        $order->dynamic_qris = $this->qrisService->generateDynamic($masterQris, $qrisAmount);

        return view('order.payment', compact('order'));
    }

    /**
     * Menampilkan halaman sukses setelah pembayaran
     * Akses diizinkan jika:
     *  - User terautentikasi adalah pemilik order, ATAU
     *  - Session order_number cocok dengan order yang diminta (alur guest checkout)
     */
    public function success($orderNumber)
    {
        $order = Order::with('theme')->where('order_number', $orderNumber)->firstOrFail();

        $sessionOrder = session('order_number');
        $isOwner = Auth::check() && $order->user_id === Auth::id();
        $isSessionMatch = $sessionOrder && hash_equals((string) $sessionOrder, (string) $orderNumber);

        if (!$isOwner && !$isSessionMatch) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return view('order.success', compact('order'));
    }
}
