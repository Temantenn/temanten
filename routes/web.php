<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Models\Invitation;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\CheckinController;

Route::get('/storage/invitations/{uuid}/{filename}', function ($uuid, $filename) {
    // Validate uuid format to prevent path traversal
    if (!preg_match('/^[a-f0-9\-]{36}$/i', $uuid)) {
        abort(404);
    }

    // Sanitize filename to prevent path traversal
    if (basename($filename) !== $filename || str_contains($filename, '/') || str_contains($filename, '\\')) {
        abort(404);
    }

    $invitation = Invitation::where('uuid', $uuid)->first();
    if (!$invitation) {
        abort(404);
    }

    $relativePath = "invitations/{$invitation->id}/{$filename}";

    $disk = Storage::disk(config('filesystems.default', 'public'));

    if (!$disk->exists($relativePath)) {
        abort(404);
    }

    $file = $disk->get($relativePath);
    $type = $disk->mimeType($relativePath);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    $response->header("Cache-Control", "public, max-age=3600");

    return $response;
})->middleware(['signed', 'throttle:signed-images'])->name('storage.images');

// Fallback: serve storage files directly (bypass symlink issue on LiteSpeed/cPanel)
// This route catches ALL /storage/* requests that aren't served by the symlink
Route::get('/storage/{path}', function ($path) {
    // Prevent path traversal
    $path = str_replace('..', '', $path);

    // Invitation media must go through the signed route above.
    if (str_starts_with($path, 'invitations/')) {
        abort(404);
    }
    $fullPath = storage_path('app/public/' . $path);

    // Ensure the resolved path is within storage
    if (!str_starts_with(realpath($fullPath) ?: '', realpath(storage_path('app/public')) ?: '')) {
        abort(404);
    }

    if (!file_exists($fullPath) || !is_file($fullPath)) {
        abort(404);
    }

    $mime = mime_content_type($fullPath);
    return response()->file($fullPath, [
        'Content-Type' => $mime,
        'Cache-Control' => 'public, max-age=86400',
    ]);
})->where('path', '.*')->name('storage.fallback');

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');
Route::get('/themes/{slug}', [ThemeController::class, 'show'])->name('themes.show');

Route::get('/buat-undangan', [OrderController::class, 'create'])->name('order.create');
Route::post('/buat-undangan', [OrderController::class, 'store'])->middleware('throttle:5,1')->name('order.store');
Route::get('/pembayaran', [OrderController::class, 'payment'])->name('order.payment');
Route::get('/order-success/{order_number}', [OrderController::class, 'success'])->name('order.success');

Route::get('/demo/{theme}', [InvitationController::class, 'demo'])->name('demo.show');
Route::get('/undangan/{slug}', [InvitationController::class, 'show'])->name('invitation.show');

// QR Check-in — public endpoint untuk staff venue scan QR tamu
// Throttle 30/menit per IP untuk cegah spam scan
Route::middleware('throttle:30,1')->group(function () {
    Route::get('/check-in/{invitation}/{token}', [CheckinController::class, 'show'])->name('checkin.show');
    Route::post('/check-in/{invitation}/{token}', [CheckinController::class, 'confirm'])->name('checkin.confirm');
});

Route::middleware('throttle:10,1')->group(function () {
    Route::post('/kirim-ucapan', [InvitationController::class, 'kirimUcapan'])->name('kirim.ucapan');
    Route::get('/undangan/{slug}/ucapan', [InvitationController::class, 'listUcapan'])->name('invitation.ucapan.index');
    Route::post('/undangan/{slug}/ucapan', [InvitationController::class, 'storeUcapan'])->name('invitation.ucapan.store');
    Route::post('/rsvp/{id}', [InvitationController::class, 'submitRSVP'])->name('invitation.rsvp');
});

// API Wilayah Indonesia (proxy ke emsifa, dengan cache)
Route::prefix('api/wilayah')->middleware('throttle:60,1')->group(function () {
    Route::get('/provinces', [WilayahController::class, 'provinces'])->name('wilayah.provinces');
    Route::get('/regencies/{province_id}', [WilayahController::class, 'regencies'])->name('wilayah.regencies');
    Route::get('/districts/{regency_id}', [WilayahController::class, 'districts'])->name('wilayah.districts');
    Route::get('/villages/{district_id}', [WilayahController::class, 'villages'])->name('wilayah.villages');
});


Route::get('/sitemap.xml', function () {
    return response()->view('sitemap.xml', [], 200)
        ->header('Content-Type', 'application/xml; charset=utf-8')
        ->header('Cache-Control', 'public, max-age=3600');
})->name('sitemap');

Route::prefix('blog')->group(function () {
    Route::get('/', [App\Http\Controllers\BlogController::class, 'index'])->name('blog.index');
    Route::get('/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
});



require __DIR__ . '/auth.php';

Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('client.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::post('/approve/{id}', [AdminController::class, 'approve'])->name('admin.approve');
    Route::post('/reject/{id}', [AdminController::class, 'reject'])->name('admin.reject');
    Route::post('/reset-password/{user_id}', [AdminController::class, 'resetPassword'])->name('admin.resetPassword');
    Route::post('/invitations/{id}/cancel', [AdminController::class, 'cancelInvitation'])->name('admin.invitations.cancel');

    // Harga: dipindah ke /themes-pricing agar tidak konflik dengan resource 'themes' di bawah
    Route::get('/themes-pricing', [AdminController::class, 'themes'])->name('admin.themes.pricing');
    Route::post('/themes/{id}/price', [AdminController::class, 'updateThemePrice'])->name('admin.themes.price');
    Route::post('/themes/default-price', [AdminController::class, 'updateDefaultPrice'])->name('admin.themes.defaultPrice');

    // Manajemen Thumbnail + Default Music (CRUD)
    Route::resource('themes', App\Http\Controllers\Admin\ThemeController::class)->only(['index', 'update'])->names('admin.themes');

    Route::get('/admins', [AdminController::class, 'admins'])->name('admin.admins');
    Route::post('/admins', [AdminController::class, 'storeAdmin'])->name('admin.storeAdmin');
    Route::delete('/admins/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.destroyAdmin');
    Route::post('/change-password', [AdminController::class, 'changePassword'])->name('admin.changePassword');
});

Route::middleware(['auth'])->prefix('client')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index'])->name('client.dashboard');

    Route::post('/import-guests', [ClientController::class, 'importGuests'])->name('client.importGuests');
    Route::get('/download-template', [ClientController::class, 'downloadTemplate'])->name('client.downloadTemplate');
    Route::get('/export-guests/{invitation}', [ClientController::class, 'exportGuests'])->name('client.exportGuests');
    Route::get('/print-qr-cards', [ClientController::class, 'printQrCards'])->name('client.printQrCards');

    Route::post('/store-guest', [ClientController::class, 'storeGuest'])->name('client.storeGuest');
    Route::delete('/delete-guest/{guest}', [ClientController::class, 'deleteGuest'])->name('client.deleteGuest');

    Route::get('/settings', [ClientController::class, 'settings'])->name('client.settings');
    Route::put('/settings', [ClientController::class, 'updateSettings'])->name('client.updateSettings');
});

// DEV ONLY — auto-login for testing
Route::get("/dev-login/{email}", function ($email) {
    if (!app()->environment("local")) abort(403);
    $u = \App\Models\User::where("email", $email)->firstOrFail();
    \Illuminate\Support\Facades\Auth::login($u, true);
    return redirect("/client/settings");
});

// DEV ONLY — set order session for payment preview
Route::get("/dev-payment/{orderNumber}", function ($orderNumber) {
    if (!app()->environment("local")) abort(403);
    session(["order_number" => $orderNumber]);
    return redirect("/pembayaran");
});

// DEV ONLY — render payment view directly with dummy QRIS for visual audit
Route::get("/dev-payment-audit/{orderNumber}", function ($orderNumber) {
    if (!app()->environment("local")) abort(403);

    $order = \App\Models\Order::with(['theme', 'user'])->where('order_number', $orderNumber)->firstOrFail();
    // Inject dummy QRIS for visual preview only
    $order->dynamic_qris = '00000000000000000000';
    return view('order.payment', ['order' => $order, '__dev_audit' => true]);
});
