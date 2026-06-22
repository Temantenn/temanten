<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetAdminPassword extends Command
{
    protected $signature = 'admin:reset-password {email?} {password?}';
    protected $description = 'Reset admin password (default: admin@temanten.id / temanten123)';

    public function handle()
    {
        $email = $this->argument('email') ?? 'admin@temanten.id';
        $password = $this->argument('password') ?? 'temanten123';

        $admin = User::where('email', $email)->first();

        if (!$admin) {
            $this->error("Admin with email {$email} not found!");
            $this->info("Creating new admin account...");
            
            $admin = User::create([
                'name' => 'Admin Temanten',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);
            
            $this->info("✓ Admin created successfully!");
        } else {
            $admin->update([
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);
            
            $this->info("✓ Password reset successfully!");
        }

        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['Email', $email],
                ['Password', $password],
                ['Role', 'admin'],
            ]
        );

        return Command::SUCCESS;
    }
}
