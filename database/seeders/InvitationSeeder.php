<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Theme;
use App\Models\Invitation;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class InvitationSeeder extends Seeder
{
    public function run(): void
    {
        $themes = Theme::take(6)->get();
        if ($themes->isEmpty()) {
            $this->command->warn('No themes found, run ThemeSeeder first.');
            return;
        }

        $pairs = [
            ['pria' => 'Andi Wijaya', 'wanita' => 'Sari Dewi', 'wa' => '6281234567890', 'tema' => 'floral-pastel', 'status' => 'pending', 'date' => '2026-07-15'],
            ['pria' => 'Budi Santoso', 'wanita' => 'Lestari Putri', 'wa' => '6281234567891', 'tema' => 'royal-glass', 'status' => 'pending', 'date' => '2026-08-22'],
            ['pria' => 'Candra Kusuma', 'wanita' => 'Maya Anggraini', 'wa' => '6281234567892', 'tema' => 'rustic-green', 'status' => 'pending', 'date' => '2026-09-10'],
            ['pria' => 'Doni Pratama', 'wanita' => 'Putri Maharani', 'wa' => '6281234567893', 'tema' => 'golden-sunrise', 'status' => 'active', 'date' => '2026-06-05'],
            ['pria' => 'Eko Saputra', 'wanita' => 'Rina Wulandari', 'wa' => '6281234567894', 'tema' => 'boho-terracotta', 'status' => 'active', 'date' => '2026-05-20'],
            ['pria' => 'Fajar Nugroho', 'wanita' => 'Sinta Bella', 'wa' => '6281234567895', 'tema' => 'celestial-night', 'status' => 'active', 'date' => '2026-04-18'],
            ['pria' => 'Galih Pranata', 'wanita' => 'Tari Kusumadewi', 'wa' => '6281234567896', 'tema' => 'cherry-blossom', 'status' => 'active', 'date' => '2026-03-12'],
            ['pria' => 'Hadi Wibowo', 'wanita' => 'Yuni Safitri', 'wa' => '6281234567897', 'tema' => 'emerald-garden', 'status' => 'active', 'date' => '2026-02-28'],
        ];

        foreach ($pairs as $p) {
            $pria   = strtolower(explode(' ', $p['pria'])[0]);
            $wanita = strtolower(explode(' ', $p['wanita'])[0]);
            $email  = "{$pria}.{$wanita}@temanten.inv";
            $slug   = Str::slug($p['pria'].'-'.$p['wanita']);

            $theme = $themes->firstWhere('slug', $p['tema']) ?? $themes->random();

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name'     => $p['pria'].' & '.$p['wanita'],
                    'password' => Hash::make('temanten123'),
                    'role'     => 'client',
                    'email_verified_at' => now(),
                ]
            );

            Invitation::firstOrCreate(
                ['slug' => $slug],
                [
                    'uuid'             => Str::uuid(),
                    'theme_id'         => $theme->id,
                    'user_id'          => $user->id,
                    'slug'             => $slug,
                    'client_whatsapp'  => $p['wa'],
                    'status'           => $p['status'],
                    'event_date'       => Carbon::parse($p['date'].' 08:00:00'),
                    'content'          => [
                        'mempelai' => [
                            'pria'   => ['nama' => $p['pria'], 'panggilan' => explode(' ', $p['pria'])[0]],
                            'wanita' => ['nama' => $p['wanita'], 'panggilan' => explode(' ', $p['wanita'])[0]],
                        ],
                        'acara' => [
                            'akad'    => ['waktu' => $p['date'].' 08:00:00', 'tempat' => 'Masjid Al-Ikhlas'],
                            'resepsi' => ['waktu' => $p['date'].' 11:00:00', 'tempat' => 'Grand Ballroom'],
                        ],
                    ],
                ]
            );
        }

        $this->command->info('8 invitations seeded (3 pending + 5 active with users).');
    }
}
