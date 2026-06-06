<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Theme;

return new class extends Migration
{
    public function up(): void
    {
        Theme::updateOrCreate(
            ['slug' => 'celestial-night'],
            [
                'name' => 'Celestial Night',
                'view_path' => 'themes.celestial-night.index',
                'description' => 'Romantic starry night theme with moon, shooting stars, and golden celestial accents',
                'is_active' => true,
            ]
        );
    }

    public function down(): void
    {
        Theme::where('slug', 'celestial-night')->delete();
    }
};