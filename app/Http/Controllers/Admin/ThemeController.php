<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ThemeController extends Controller
{
    /**
     * Daftar tema (Thumbnail + Default Music management).
     */
    public function index()
    {
        $themes = Theme::orderBy('id')->get();
        return view('admin.themes.index', compact('themes'));
    }

    /**
     * Update thumbnail (auto-convert ke WebP via GD) + default_music.
     */
    public function update(Request $request, $id)
    {
        /** @var Theme|null $theme */
        $theme = Theme::findOrFail($id);

        $validated = $request->validate([
            'thumbnail'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:8192'],
            'default_music'=> ['nullable', 'mimes:mp3,m4a,wav,ogg', 'max:20480'],
        ], [], [
            'thumbnail'    => 'Thumbnail',
            'default_music'=> 'Default Music',
        ]);

        // === Thumbnail: auto-convert + compress ke WebP via GD ===
        if ($request->hasFile('thumbnail')) {
            $thumbFile = $request->file('thumbnail');
            $ext = strtolower($thumbFile->getClientOriginalExtension());

            // Ensure destination directory
            $thumbDir = storage_path('app/public/themes/thumbnails');
            if (!is_dir($thumbDir)) {
                @mkdir($thumbDir, 0775, true);
            }

            $filename = Str::slug($theme->slug) . '-' . time() . '.webp';
            $destAbs  = $thumbDir . DIRECTORY_SEPARATOR . $filename;

            // Load via GD sesuai ekstensi asli
            $src = null;
            try {
                if (in_array($ext, ['jpg', 'jpeg'], true)) {
                    $src = @imagecreatefromjpeg($thumbFile->getRealPath());
                } elseif ($ext === 'png') {
                    $src = @imagecreatefrompng($thumbFile->getRealPath());
                } elseif ($ext === 'webp') {
                    if (function_exists('imagecreatefromwebp')) {
                        $src = @imagecreatefromwebp($thumbFile->getRealPath());
                    } else {
                        // Fallback: keep as webp directly
                        $thumbFile->move($thumbDir, $filename);
                        $src = null;
                    }
                }

                if ($src instanceof \GdImage) {
                    // Preserve transparency for PNG-ish sources by saving alpha info
                    imagealphablending($src, true);
                    imagesavealpha($src, true);
                    // Convert + compress: quality 80 (good balance)
                    imagewebp($src, $destAbs, 80);
                    imagedestroy($src);
                } elseif (!file_exists($destAbs)) {
                    // Last resort fallback: just move the file
                    $thumbFile->move($thumbDir, $filename);
                }
            } catch (\Throwable $e) {
                // Fallback jika GD error: tetap simpan file original
                if (!file_exists($destAbs)) {
                    $thumbFile->move($thumbDir, $filename);
                }
            }

            // Hapus file lama jika ada (best-effort)
            if (!empty($theme->thumbnail) && $theme->thumbnail !== $filename && Storage::disk('public')->exists('themes/thumbnails/' . $theme->thumbnail)) {
                @Storage::disk('public')->delete('themes/thumbnails/' . $theme->thumbnail);
            }

            $theme->thumbnail = $filename;
        }

        // === Default music: simpan apa adanya ===
        if ($request->hasFile('default_music')) {
            $musicFile = $request->file('default_music');
            $musicDir  = storage_path('app/public/themes/music');
            if (!is_dir($musicDir)) {
                @mkdir($musicDir, 0775, true);
            }
            $musicName = Str::slug($theme->slug) . '-' . time() . '.' . strtolower($musicFile->getClientOriginalExtension());

            // Hapus file lama jika ada
            if (!empty($theme->default_music) && $theme->default_music !== $musicName && Storage::disk('public')->exists('themes/music/' . $theme->default_music)) {
                @Storage::disk('public')->delete('themes/music/' . $theme->default_music);
            }

            $musicFile->move($musicDir, $musicName);
            $theme->default_music = $musicName;
        }

        $theme->save();

        return redirect()
            ->route('admin.themes.index')
            ->with('success', 'Tema "' . $theme->name . '" berhasil diperbarui.');
    }
}
