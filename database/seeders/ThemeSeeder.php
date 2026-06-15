<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            ['name' => 'Rustic Green', 'slug' => 'rustic-green', 'thumbnail' => 'rustic-green.webp', 'view_path' => 'themes.rustic-green.index', 'description' => 'Tema rustic natural dengan nuansa hijau hangat dan elegan.'],
            ['name' => 'Floral Pastel', 'slug' => 'floral-pastel', 'thumbnail' => 'floral-pastel.webp', 'view_path' => 'themes.floral-pastel.index', 'description' => 'Tema floral lembut bernuansa pastel romantis.'],
            ['name' => 'Royal Glass', 'slug' => 'royal-glass', 'thumbnail' => 'royal-glass.webp', 'view_path' => 'themes.royal-glass.index', 'description' => 'Tema mewah bergaya glassmorphism modern.'],
            ['name' => 'Barakah Love', 'slug' => 'barakah-love', 'thumbnail' => 'barakah-love.webp', 'view_path' => 'themes.barakah-love.index', 'description' => 'Tema Islami elegan dengan suasana sakral dan penuh berkah.'],
            ['name' => 'Boho Terracotta', 'slug' => 'boho-terracotta', 'thumbnail' => 'boho-terracotta.webp', 'view_path' => 'themes.boho-terracotta.index', 'description' => 'Tema bohemian hangat dengan palet terracotta.'],
            ['name' => 'Emerald Garden', 'slug' => 'emerald-garden', 'thumbnail' => 'emerald-garden.webp', 'view_path' => 'themes.emerald-garden.index', 'description' => 'Tema taman emerald yang segar, elegan, dan premium.'],
            ['name' => 'Ocean Breeze', 'slug' => 'ocean-breeze', 'thumbnail' => 'ocean-breeze.webp', 'view_path' => 'themes.ocean-breeze.index', 'description' => 'Tema pantai biru sejuk dengan nuansa angin laut.'],
            ['name' => 'Watercolor Flow', 'slug' => 'watercolor-flow', 'thumbnail' => 'watercolor-flow.webp', 'view_path' => 'themes.watercolor-flow.index', 'description' => 'Tema watercolor artistik dengan transisi warna lembut.'],
            ['name' => 'Golden Sunrise', 'slug' => 'golden-sunrise', 'thumbnail' => 'golden-sunrise.webp', 'view_path' => 'themes.golden-sunrise.index', 'description' => 'Tema golden sunrise cerah, hangat, dan optimis.'],
            ['name' => 'Jawa Keraton', 'slug' => 'jawa-keraton', 'thumbnail' => 'jawa-keraton.webp', 'view_path' => 'themes.jawa-keraton.index', 'description' => 'Tema adat Jawa klasik dengan sentuhan keraton.'],
            ['name' => 'Midnight Garden', 'slug' => 'midnight-garden', 'thumbnail' => 'midnight-garden.webp', 'view_path' => 'themes.midnight-garden.index', 'description' => 'Tema taman malam elegan dengan aksen gelap romantis.'],
            ['name' => 'Sekar Jagad', 'slug' => 'sekar-jagad', 'thumbnail' => 'sekar-jagad.webp', 'view_path' => 'themes.sekar-jagad.index', 'description' => 'Tema batik Sekar Jagad dengan nuansa budaya Nusantara.'],
            ['name' => 'Sunda Asih', 'slug' => 'sunda-asih', 'thumbnail' => 'sunda-asih.webp', 'view_path' => 'themes.sunda-asih.index', 'description' => 'Tema adat Sunda romantis, lembut, dan penuh asih.'],
            ['name' => 'Pixel Adventure', 'slug' => 'pixel-adventure', 'thumbnail' => 'pixel-adventure.webp', 'view_path' => 'themes.pixel-adventure.index', 'description' => 'Tema undangan bergaya retro pixel art seperti game petualangan.'],
            ['name' => 'Cherry Blossom', 'slug' => 'cherry-blossom', 'thumbnail' => 'cherry-blossom.webp', 'view_path' => 'themes.cherry-blossom.index', 'description' => 'Tema sakura romantis dengan animasi kelopak bunga lembut.'],
            ['name' => 'Celestial Night', 'slug' => 'celestial-night', 'thumbnail' => 'celestial-night.webp', 'view_path' => 'themes.celestial-night.index', 'description' => 'Tema malam berbintang dengan bulan dan aksen emas romantis.'],
        ];

        foreach ($themes as $theme) {
            Theme::updateOrCreate(
                ['slug' => $theme['slug']],
                $theme + ['is_active' => true]
            );
        }
    }
}