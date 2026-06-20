<?php
// DIAGNOSTIC: Check current admin state, output to log file for fetch
$log = storage_path('logs/admin-reset.log');
file_put_contents($log, "=== Admin diagnostic at " . now()->toIso8601String() . " ===\n", FILE_APPEND);

$admins = App\Models\User::where('role', 'admin')->get();
file_put_contents($log, "Admins found: " . $admins->count() . "\n", FILE_APPEND);

if ($admins->count() === 0) {
    file_put_contents($log, "NO ADMIN — creating one\n", FILE_APPEND);
    $u = App\Models\User::create([
        'name' => 'Admin Temanten',
        'email' => 'admin@temanten.test',
        'password' => Hash::make('admin123'),
        'role' => 'admin',
        'email_verified_at' => now(),
    ]);
    file_put_contents($log, "Created admin id={$u->id} email={$u->email} pw=admin123\n", FILE_APPEND);
} else {
    $u = $admins->first();
    $u->password = Hash::make('GaEzX7EGlHJ9VWAkNK7O');
    $u->save();
    file_put_contents($log, "Reset password for id={$u->id} email={$u->email} new_pw=GaEzX7EGlHJ9VWAkNK7O\n", FILE_APPEND);
}

file_put_contents($log, "DONE\n\n", FILE_APPEND);
echo "Log written to: $log\n";
echo "New password: GaEzX7EGlHJ9VWAkNK7O\n";
