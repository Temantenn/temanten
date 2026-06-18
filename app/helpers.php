<?php
/**
 * Theme asset helpers — single source of truth untuk URL/path thumbnail & musik.
 *
 * Cek 2 lokasi (urutan prioritas):
 *   1. storage/app/public/themes/{thumbnails|music}/  ← upload admin (slug-{timestamp}.webp)
 *   2. public/assets/{thumbnail|music}/              ← legacy / source seed
 *
 * Pakai di view manapun yang render thumbnail/musik tema.
 */

if (!function_exists('theme_thumb_url')) {
    /**
     * Return URL publik untuk thumbnail tema. Null kalau ga ada di kedua lokasi.
     *
     * @param  \App\Models\Theme|string|null  $theme   Model atau slug string
     * @param  string  $fallbackSlug  Slug fallback kalau DB ga ada record
     * @return string|null
     */
    function theme_thumb_url($theme = null, string $fallbackSlug = 'floral-pastel'): ?string
    {
        // Resolve filename
        if ($theme instanceof \App\Models\Theme) {
            $filename = $theme->thumbnail ?: ($theme->slug . '.webp');
        } elseif (is_string($theme) && $theme !== '') {
            $filename = $theme . '.webp';
        } else {
            $filename = $fallbackSlug . '.webp';
        }

        // Prioritas 1: storage/app/public (upload admin)
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists('themes/thumbnails/' . $filename)) {
            return asset('storage/themes/thumbnails/' . $filename);
        }

        // Prioritas 2: public/assets (legacy / source seed)
        if (file_exists(public_path('assets/thumbnail/' . $filename))) {
            return asset('assets/thumbnail/' . $filename);
        }

        // Last resort: fallback slug
        if (file_exists(public_path('assets/thumbnail/' . $fallbackSlug . '.webp'))) {
            return asset('assets/thumbnail/' . $fallbackSlug . '.webp');
        }

        return null;
    }
}

if (!function_exists('theme_music_url')) {
    /**
     * Return URL publik untuk default music tema. Null kalau ga ada.
     *
     * @param  \App\Models\Theme|string|null  $theme   Model atau slug string
     * @param  string  $fallbackSlug  Slug fallback
     * @return string|null
     */
    function theme_music_url($theme = null, string $fallbackSlug = 'floral-pastel'): ?string
    {
        if ($theme instanceof \App\Models\Theme) {
            $filename = $theme->default_music ?: ($theme->slug . '.mp3');
            $fallbackSlug = $theme->slug ?: $fallbackSlug;
        } elseif (is_string($theme) && $theme !== '') {
            $filename = $theme . '.mp3';
            $fallbackSlug = $theme;
        } else {
            $filename = $fallbackSlug . '.mp3';
        }

        // Prioritas 1: storage/app/public (upload admin)
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists('themes/music/' . $filename)) {
            return asset('storage/themes/music/' . $filename);
        }

        // Prioritas 2: public/assets (legacy / source seed)
        if (file_exists(public_path('assets/music/' . $filename))) {
            return asset('assets/music/' . $filename);
        }

        // Last resort: fallback slug
        if (file_exists(public_path('assets/music/' . $fallbackSlug . '.mp3'))) {
            return asset('assets/music/' . $fallbackSlug . '.mp3');
        }

        return null;
    }
}