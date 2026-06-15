<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\Theme;

return new class extends Migration
{
    public function up(): void
    {
        Theme::updateOrCreate(
            ['slug' => 'cherry-blossom'],
            [
                'name' => 'Cherry Blossom',
                'thumbnail' => 'cherry-blossom.webp',
                'view_path' => 'themes.cherry-blossom.index',
                'description' => 'Sakura-inspired romantic wedding invitation with falling petal animations',
                'is_active' => true,
            ]
        );
    }

    public function down(): void
    {
        Theme::where('slug', 'cherry-blossom')->delete();
    }
};