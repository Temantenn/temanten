<?php

namespace Tests\Feature;

use App\Models\Theme;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class DemoRouteTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        $this->resetSchema();
    }

    public function test_new_theme_demo_routes_render_without_missing_music_file_errors(): void
    {
        $themes = [
            ['name' => 'Pixel Adventure', 'slug' => 'pixel-adventure', 'view_path' => 'themes.pixel-adventure.index'],
            ['name' => 'Cherry Blossom', 'slug' => 'cherry-blossom', 'view_path' => 'themes.cherry-blossom.index'],
            ['name' => 'Celestial Night', 'slug' => 'celestial-night', 'view_path' => 'themes.celestial-night.index'],
        ];

        foreach ($themes as $theme) {
            Theme::create($theme + [
                'thumbnail' => $theme['slug'] . '.png',
                'is_active' => true,
            ]);
        }

        foreach (array_column($themes, 'slug') as $slug) {
            $this->get(route('demo.show', $slug))
                ->assertOk();
        }
    }

    public function test_demo_supplies_optional_region_and_qris_data(): void
    {
        Theme::create([
            'name' => 'Cherry Blossom',
            'slug' => 'cherry-blossom',
            'view_path' => 'themes.cherry-blossom.index',
            'thumbnail' => 'cherry-blossom.png',
            'is_active' => true,
        ]);

        $response = $this->get(route('demo.show', 'cherry-blossom'));

        $response->assertOk()
            ->assertSee('DKI Jakarta')
            ->assertSee('img/qris.webp');
    }

    public function test_demo_guest_token_query_does_not_break_dummy_invitation(): void
    {
        Theme::create([
            'name' => 'Floral Pastel',
            'slug' => 'floral-pastel',
            'view_path' => 'themes.floral-pastel.index',
            'thumbnail' => 'floral-pastel.png',
            'is_active' => true,
        ]);

        $this->get(route('demo.show', ['theme' => 'floral-pastel', 'to' => 'demo-guest']))
            ->assertOk();
    }

    private function resetSchema(): void
    {
        Schema::dropIfExists('themes');

        Schema::create('themes', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('view_path');
            $table->string('thumbnail')->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('price')->nullable();
            $table->integer('promo_price')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
}
