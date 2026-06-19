<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * Sync themes.thumbnail extension: convert all .png references to .webp.
 *
 * Reason: Admin WebP optimization feature (2026-06) converted all theme
 * thumbnail assets from .png to .webp for performance, but DB column
 * references were not updated in sync. This migration brings DB in line
 * with the actual files on disk under storage/app/public/themes/thumbnails/.
 *
 * Safe & idempotent: REPLACE only runs WHERE thumbnail LIKE '%.png'.
 * If a row already has .webp, it is untouched.
 */
return new class extends Migration
{
    public function up(): void
    {
        $count = DB::table('themes')
            ->where('thumbnail', 'like', '%.png')
            ->count();

        if ($count > 0) {
            DB::statement("UPDATE themes SET thumbnail = REPLACE(thumbnail, '.png', '.webp') WHERE thumbnail LIKE '%.png'");
            echo "[fix-thumbnails] Updated {$count} themes: .png -> .webp\n";
        } else {
            echo "[fix-thumbnails] No .png references found, skip\n";
        }
    }

    public function down(): void
    {
        $count = DB::table('themes')
            ->where('thumbnail', 'like', '%.webp')
            ->count();

        if ($count > 0) {
            DB::statement("UPDATE themes SET thumbnail = REPLACE(thumbnail, '.webp', '.png') WHERE thumbnail LIKE '%.webp'");
            echo "[fix-thumbnails] Rolled back {$count} themes: .webp -> .png\n";
        }
    }
};
