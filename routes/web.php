<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\WilayahController;

Route::get('/storage/invitations/{uuid}/{filename}', function ($uuid, $filename) {
    $path = "public/invitations/{$uuid}/{$filename}";

    if (!Storage::exists($path)) {
        abort(404);
    }

    $file = Storage::get($path);
    $type = Storage::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->name('storage.images');

Route::get('/', function () {
    return view('landing');
})->name('home');

Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');
Route::get('/themes/{slug}', [ThemeController::class, 'show'])->name('themes.show');

Route::get('/buat-undangan', [OrderController::class, 'create'])->name('order.create');
Route::post('/buat-undangan', [OrderController::class, 'store'])->name('order.store');
Route::get('/pembayaran', [OrderController::class, 'payment'])->name('order.payment');
Route::get('/order-success/{id}', [OrderController::class, 'success'])->name('order.success');

Route::get('/demo/{theme}', [InvitationController::class, 'demo'])->name('demo.show');
Route::get('/undangan/{slug}', [InvitationController::class, 'show'])->name('invitation.show');

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
    Route::post('/reset-password/{user_id}', [AdminController::class, 'resetPassword'])->name('admin.resetPassword');

    Route::get('/themes', [AdminController::class, 'themes'])->name('admin.themes');
    Route::post('/themes/{id}/price', [AdminController::class, 'updateThemePrice'])->name('admin.themes.price');
    Route::post('/themes/default-price', [AdminController::class, 'updateDefaultPrice'])->name('admin.themes.defaultPrice');

    Route::get('/admins', [AdminController::class, 'admins'])->name('admin.admins');
    Route::post('/admins', [AdminController::class, 'storeAdmin'])->name('admin.storeAdmin');
    Route::delete('/admins/{id}', [AdminController::class, 'destroyAdmin'])->name('admin.destroyAdmin');
});

Route::middleware(['auth'])->prefix('client')->group(function () {
    Route::get('/dashboard', [ClientController::class, 'index'])->name('client.dashboard');

    Route::post('/import-guests', [ClientController::class, 'importGuests'])->name('client.importGuests');
    Route::get('/download-template', [ClientController::class, 'downloadTemplate'])->name('client.downloadTemplate');
    Route::get('/export-guests/{invitation}', [ClientController::class, 'exportGuests'])->name('client.exportGuests');

    Route::post('/store-guest', [ClientController::class, 'storeGuest'])->name('client.storeGuest');
    Route::delete('/delete-guest/{guest}', [ClientController::class, 'deleteGuest'])->name('client.deleteGuest');

    Route::get('/settings', [ClientController::class, 'settings'])->name('client.settings');
    Route::put('/settings', [ClientController::class, 'updateSettings'])->name('client.updateSettings');
});
