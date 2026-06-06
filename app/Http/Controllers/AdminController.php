<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Invitation;
use App\Models\ActivityLog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Mail\InvitationApprovedMail;

class AdminController extends Controller
{

    public function index()
    {
        // Eager load 'user' pada kedua query untuk menghindari N+1 query
        $pendingOrders = Invitation::where('status', 'pending')
            ->with('user', 'theme')
            ->latest()
            ->paginate(20, pageName: 'pending_page');

        $activeOrders = Invitation::where('status', 'active')
            ->with('user', 'theme')
            ->latest()
            ->paginate(20, pageName: 'active_page');

        return view('admin.dashboard', compact('pendingOrders', 'activeOrders'));
    }

    public function approve($id)
    {
        $invitation = Invitation::with('user')->findOrFail($id);

        if ($invitation->status === 'active') {
            return redirect()->back()->with('error', 'Pesanan ini sudah aktif sebelumnya!');
        }

        $credentials = [];
        $user = $invitation->user;

        try {
            DB::transaction(function () use ($invitation, &$credentials, $user) {
                
                // Cek jika email masih dummy bawaan order
                $email = $user->email;
                if (str_ends_with($email, '@temanten.biz.id')) {
                    $content  = $invitation->content;
                    $namaPria = $content['mempelai']['pria']['nama'] ?? 'Mempelai Pria';
                    $namaWanita = $content['mempelai']['wanita']['nama'] ?? 'Mempelai Wanita';

                    $pria   = strtolower(preg_replace('/[^a-z0-9]/i', '', explode(' ', trim($namaPria))[0]));
                    $wanita = strtolower(preg_replace('/[^a-z0-9]/i', '', explode(' ', trim($namaWanita))[0]));

                    $baseEmail = "{$pria}.{$wanita}";
                    $newEmail  = $baseEmail . '@temanten.inv';

                    $counter = 1;
                    while (User::where('email', $newEmail)->where('id', '!=', $user->id)->exists()) {
                        $newEmail = $baseEmail . $counter . '@temanten.inv';
                        $counter++;
                    }
                    $email = $newEmail;
                }

                $rawPassword = Str::random(8);

                $user->update([
                    'email'    => $email,
                    'password' => Hash::make($rawPassword),
                ]);

                $invitation->update([
                    'status'  => 'active',
                ]);

                // Set default expiry
                $invitation->setDefaultExpiry();

                $credentials = [
                    'name'     => $user->name,
                    'email'    => $email,
                    'password' => $rawPassword,
                ];
            });

            // Log aktivitas admin: persetujuan undangan
            ActivityLog::record('admin_action', 'invitation.approved', $invitation, [
                'invitation_slug' => $invitation->slug,
                'approved_by'     => Auth::user()->email,
            ]);

            Log::channel('daily')->info('Admin approved invitation', [
                'admin'           => Auth::user()->email,
                'invitation_id'   => $invitation->id,
                'invitation_slug' => $invitation->slug,
            ]);

            // Jangan kirim email jika email dummy .inv atau .biz.id
            if (!str_ends_with($user->email, '.inv') && !str_ends_with($user->email, '.biz.id')) {
                try {
                    Mail::to($user->email)->send(new InvitationApprovedMail($invitation, $credentials['password']));
                } catch (\Throwable $e) {
                    Log::channel('daily')->warning('Failed to send approval email', [
                        'invitation_id' => $invitation->id,
                        'error'         => $e->getMessage(),
                    ]);
                }
            }

            return redirect()->back()->with('new_account', $credentials);

        } catch (\Exception $e) {

            Log::channel('daily')->error('Failed to approve invitation', [
                'admin'         => Auth::user()->email,
                'invitation_id' => $id,
                'error'         => $e->getMessage(),
                'trace'         => $e->getTraceAsString(),
            ]);

            return redirect()->back()->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage() . ' di baris ' . $e->getLine());
        }
    }

    public function resetPassword($user_id)
    {
        $user = User::findOrFail($user_id);

        $newPassword = Str::random(8);

        $user->update([
            'password' => Hash::make($newPassword),
        ]);

        // Log aktivitas admin: reset password klien
        ActivityLog::record('admin_action', 'user.password_reset', $user, [
            'target_email'  => $user->email,
            'reset_by'      => Auth::user()->email,
        ]);

        Log::channel('daily')->info('Admin reset client password', [
            'admin'        => Auth::user()->email,
            'target_user'  => $user->email,
        ]);

        return redirect()->back()->with('reset_success', [
            'name'     => $user->name,
            'email'    => $user->email,
            'password' => $newPassword,
        ]);
    }

    // ─── THEME MANAGEMENT ────────────────────────────────────────────────────

    public function themes()
    {
        $themes      = \App\Models\Theme::orderBy('name')->get();
        $defaultPrice = config('app.default_price', 99000);
        return view('admin.themes', compact('themes', 'defaultPrice'));
    }

    public function updateThemePrice(Request $request, $id)
    {
        $request->validate([
            'price' => 'nullable|integer|min:0|max:99999999',
            'promo_price' => 'nullable|integer|min:0|max:99999999',
        ]);

        $theme = \App\Models\Theme::findOrFail($id);
        
        // Cek promo price tidak boleh lebih besar dari harga asli (jika ada)
        $originalPrice = $request->filled('price') ? (int)$request->price : config('app.default_price', 99000);
        if ($request->filled('promo_price') && (int)$request->promo_price >= $originalPrice) {
            return redirect()->back()->withErrors(['promo_price' => 'Harga promo harus lebih kecil dari harga asli.']);
        }

        // null = pakai harga default global
        $theme->price = $request->filled('price') ? (int)$request->price : null;
        $theme->promo_price = $request->filled('promo_price') ? (int)$request->promo_price : null;
        $theme->save();

        ActivityLog::record('admin_action', 'theme.price_updated', $theme, [
            'theme_slug'   => $theme->slug,
            'new_price'    => $theme->price,
            'promo_price'  => $theme->promo_price,
            'updated_by'   => Auth::user()->email,
        ]);

        return redirect()->back()->with('success', "Harga tema \"{$theme->name}\" berhasil diperbarui.");
    }

    public function updateDefaultPrice(Request $request)
    {
        $request->validate([
            'default_price' => 'required|integer|min:0|max:99999999',
        ]);

        $newPrice = (int)$request->default_price;

        // Update nilai APP_DEFAULT_PRICE di .env
        $envPath = base_path('.env');
        $envContent = file_get_contents($envPath);

        if (str_contains($envContent, 'APP_DEFAULT_PRICE=')) {
            $envContent = preg_replace('/APP_DEFAULT_PRICE=\d+/', "APP_DEFAULT_PRICE={$newPrice}", $envContent);
        } else {
            $envContent .= "\nAPP_DEFAULT_PRICE={$newPrice}";
        }

        file_put_contents($envPath, $envContent);

        // Refresh cache config agar langsung berlaku
        \Illuminate\Support\Facades\Artisan::call('config:clear');

        ActivityLog::record('admin_action', 'theme.default_price_updated', null, [
            'new_default_price' => $newPrice,
            'updated_by'        => Auth::user()->email,
        ]);

        return redirect()->back()->with('success', 'Harga default berhasil diperbarui menjadi Rp ' . number_format($newPrice, 0, ',', '.'));
    }

    // ─── ADMIN MANAGEMENT ──────────────────────────────────────────────────

    public function admins()
    {
        // Fetch all admins excluding current active session if needed, but for now fetch all
        $admins = User::where('role', 'admin')->orderBy('created_at', 'desc')->get();
        return view('admin.admins', compact('admins'));
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $admin = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'admin',
        ]);

        ActivityLog::record('admin_action', 'admin.created', $admin, [
            'created_admin' => $admin->email,
            'created_by'    => Auth::user()->email,
        ]);

        return redirect()->back()->with('success', "Akun admin baru ({$admin->name}) berhasil ditambahkan.");
    }

    public function destroyAdmin($id)
    {
        $admin = User::findOrFail($id);

        if ($admin->id === Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri secara langsung.');
        }

        if ($admin->role !== 'admin') {
            return redirect()->back()->with('error', 'Akun yang dipilih bukan akun admin.');
        }

        $email = $admin->email;
        $admin->delete();

        ActivityLog::record('admin_action', 'admin.deleted', null, [
            'deleted_admin' => $email,
            'deleted_by'    => Auth::user()->email,
        ]);

        return redirect()->back()->with('success', "Akun admin {$email} berhasil dihapus permanen.");
    }
}