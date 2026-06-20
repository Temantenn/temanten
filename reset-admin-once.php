<?php
// One-time admin password reset for production
// Will be removed after first successful deploy

$user = App\Models\User::where('role', 'admin')->first();
if (!$user) {
    echo "[ERR] No admin user found\n";
    exit(1);
}

$user->password = Hash::make('oQgygYQdLiMEBg7RXq6L');
$user->save();

echo "[OK] Admin password reset for {$user->email}\n";
echo "[PW ] oQgygYQdLiMEBg7RXq6L\n";
echo "[!!] SAVE THIS PASSWORD NOW — will not be shown again\n";
