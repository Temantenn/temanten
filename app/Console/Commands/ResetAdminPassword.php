<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * One-shot admin password reset.
 *
 * Usage:
 *   php artisan temanten:reset-admin
 *   php artisan temanten:reset-admin --password=MyNewPass123
 *
 * Will be removed after first successful run.
 */
class ResetAdminPassword extends Command
{
    protected $signature = 'temanten:reset-admin {--password= : New password (random 20-char if omitted)}';
    protected $description = '[ONE-SHOT] Reset admin password on production';

    public function handle(): int
    {
        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
            $this->error('[FAIL] No admin user found');
            // Create one if missing
            $admin = User::create([
                'name'     => 'Admin Temanten',
                'email'    => 'admin@temanten.test',
                'password' => Hash::make('admin123'),
                'role'     => 'admin',
                'email_verified_at' => now(),
            ]);
            $this->warn('[WARN] Created new admin user with default password "admin123"');
            $this->warn('[!! ] CHANGE THIS PASSWORD IMMEDIATELY AFTER LOGIN');
            return self::SUCCESS;
        }

        $password = $this->option('password') ?: bin2hex(random_bytes(10));

        $admin->password = Hash::make($password);
        $admin->save();

        $this->info('[OK] Admin password reset');
        $this->line('Email:    ' . $admin->email);
        $this->line('Password: ' . $password);
        $this->warn('[!! ] SAVE THIS PASSWORD NOW — display only this once');

        return self::SUCCESS;
    }
}
