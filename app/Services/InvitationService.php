<?php

namespace App\Services;

use App\Models\Invitation;
use App\Models\ActivityLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InvitationService
{
    /**
     * Update invitation settings (stored in JSON content column).
     */
    public function updateSettings(Invitation $invitation, Request $request): Invitation
    {
        return DB::transaction(function () use ($invitation, $request) {
            $content = $invitation->content ?? [];
            $folderName = $invitation->id;

            // Mempelai Pria
            $content['mempelai']['pria']['nama'] = $request->groom_name;
            $content['mempelai']['pria']['panggilan'] = $request->groom_nickname;
            $content['mempelai']['pria']['ayah'] = $request->groom_father;
            $content['mempelai']['pria']['ibu'] = $request->groom_mother;
            $content['mempelai']['pria']['instagram'] = $request->groom_instagram;

            // Mempelai Wanita
            $content['mempelai']['wanita']['nama'] = $request->bride_name;
            $content['mempelai']['wanita']['panggilan'] = $request->bride_nickname;
            $content['mempelai']['wanita']['ayah'] = $request->bride_father;
            $content['mempelai']['wanita']['ibu'] = $request->bride_mother;
            $content['mempelai']['wanita']['instagram'] = $request->bride_instagram;

            // Quote
            $content['quote'] = $request->quote;

            // Akad
            $content['acara']['akad']['judul'] = $request->akad_title;
            $content['acara']['akad']['waktu'] = $request->akad_datetime;
            $content['acara']['akad']['tempat'] = $request->akad_location;
            $content['acara']['akad']['alamat'] = $request->akad_address;
            $content['acara']['akad']['maps'] = $request->akad_map_link;
            if ($request->akad_province_name) {
                $content['acara']['akad']['wilayah'] = [
                    'province' => $request->akad_province_name,
                    'regency'  => $request->akad_regency_name,
                    'district' => $request->akad_district_name,
                    'village'  => $request->akad_village_name,
                ];
            }

            // Resepsi
            $content['acara']['resepsi']['judul'] = $request->resepsi_title;
            $content['acara']['resepsi']['waktu'] = $request->resepsi_datetime;
            $content['acara']['resepsi']['tempat'] = $request->resepsi_location;
            $content['acara']['resepsi']['alamat'] = $request->resepsi_address;
            $content['acara']['resepsi']['maps'] = $request->resepsi_map_link;
            if ($request->resepsi_province_name) {
                $content['acara']['resepsi']['wilayah'] = [
                    'province' => $request->resepsi_province_name,
                    'regency'  => $request->resepsi_regency_name,
                    'district' => $request->resepsi_district_name,
                    'village'  => $request->resepsi_village_name,
                ];
            }

            // Amplop / Gift
            $content['amplop']['bank_name'] = $request->bank_name;
            $content['amplop']['account_number'] = $request->bank_number;
            $content['amplop']['account_holder'] = $request->bank_holder;
            $content['amplop']['alamat_kado'] = $request->gift_address;
            $content['amplop']['maps_kado'] = $request->gift_map_link;
            if ($request->kado_province_name) {
                $content['amplop']['wilayah'] = [
                    'province' => $request->kado_province_name,
                    'regency'  => $request->kado_regency_name,
                    'district' => $request->kado_district_name,
                    'village'  => $request->kado_village_name,
                ];
            }
            if (isset($invitation->content['amplop']['qris_image'])) {
                $content['amplop']['qris_image'] = $invitation->content['amplop']['qris_image'];
            }

            // Single file uploads
            $content = $this->handleSingleFileUploads($invitation, $request, $content, $folderName);

            // Gallery
            $content = $this->handleGallery($invitation, $request, $content, $folderName);

            // Video
            $content['media']['video_link'] = $request->video_link;

            // Love Stories
            $content = $this->handleLoveStories($invitation, $request, $content, $folderName);

            // Event date
            if ($request->filled('resepsi_datetime')) {
                $invitation->event_date = Carbon::parse($request->resepsi_datetime);
            } elseif ($request->filled('akad_datetime')) {
                $invitation->event_date = Carbon::parse($request->akad_datetime);
            }

            $invitation->content = $content;
            $invitation->save();

            // Invalidate public page cache
            Cache::forget("invitation:{$invitation->slug}");

            ActivityLog::record('info', 'invitation.settings_updated', $invitation, [
                'updated_by' => auth()->user()->email,
            ]);

            return $invitation;
        });
    }

    /**
     * Handle single file uploads (groom, bride, cover, og, music, qris).
     */
    protected function handleSingleFileUploads(Invitation $invitation, Request $request, array $content, $folderName): array
    {
        $fileMap = [
            'groom_photo' => ['mempelai', 'pria', 'foto'],
            'bride_photo' => ['mempelai', 'wanita', 'foto'],
            'cover_image' => ['media', 'cover'],
            'og_image'    => ['media', 'og_image'],
            'music_file'  => ['media', 'music'],
            'qris_image'  => ['amplop', 'qris_image'],
        ];

        $allowImageExts = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
        $allowAudioExts  = ['mp3', 'wav', 'ogg'];

        foreach ($fileMap as $inputName => $contentPath) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);

                // Resolve extension via MIME-type detection (defense-in-depth
                // against polyglot / shell.jpg.php uploads). Fall back to
                // original extension if mime guess is unreliable, but reject
                // anything not in the allowlist for this file's category.
                $isAudio = in_array($inputName, ['music_file'], true);
                $allow   = $isAudio ? $allowAudioExts : $allowImageExts;

                $ext = strtolower((string) $file->guessExtension());
                if (!in_array($ext, $allow, true)) {
                    $ext = strtolower($file->getClientOriginalExtension());
                }
                if (!in_array($ext, $allow, true)) {
                    $ext = $isAudio ? 'mp3' : 'jpg';
                }

                $filename = uniqid() . '_' . $inputName . '.' . $ext;
                $path = $file->storeAs("public/invitations/{$folderName}", $filename);
                $value = str_replace('public/', 'storage/', $path);

                // Set value in nested content array
                $ref = &$content;
                foreach ($contentPath as $key) {
                    $ref = &$ref[$key];
                }
                $ref = $value;
                unset($ref);
            }
        }

        return $content;
    }

    /**
     * Handle gallery photo soft-deletions, restores, and uploads.
     */
    protected function handleGallery(Invitation $invitation, Request $request, array $content, $folderName): array
    {
        $galleryPaths = array_values($content['media']['gallery'] ?? []);
        $trashPaths = array_values($content['media']['gallery_trash'] ?? []);

        // Restores from trash back to active gallery
        if ($request->has('restore_gallery')) {
            $toRestore = array_map('intval', (array) $request->restore_gallery);
            $toRestore = array_unique($toRestore);

            foreach ($toRestore as $idx) {
                if (!array_key_exists($idx, $trashPaths)) {
                    continue;
                }

                $path = $trashPaths[$idx];

                if (is_string($path) && $path !== '' && !in_array($path, $galleryPaths, true)) {
                    $galleryPaths[] = $path;
                }

                unset($trashPaths[$idx]);
            }

            $trashPaths = array_values($trashPaths);
        }

        // Soft-deletions: move to trash, do not delete physical files
        if ($request->has('delete_gallery')) {
            $toDelete = array_map('intval', (array) $request->delete_gallery);
            $toDelete = array_unique($toDelete);

            foreach ($toDelete as $idx) {
                if (!array_key_exists($idx, $galleryPaths)) {
                    continue;
                }
                $path = $galleryPaths[$idx];

                if (is_string($path) && $path !== '' && !in_array($path, $trashPaths, true)) {
                    $trashPaths[] = $path;
                }

                unset($galleryPaths[$idx]);
            }
            $galleryPaths = array_values($galleryPaths);
        }

        // New uploads
        if ($request->hasFile('gallery_photos')) {
            foreach ($request->file('gallery_photos') as $photo) {
                $ext = $this->safeImageExt($photo);
                $filename = uniqid() . '_gallery.' . $ext;
                $path = $photo->storeAs("public/invitations/{$folderName}", $filename);
                $galleryPaths[] = str_replace('public/', 'storage/', $path);
            }
        }

        $content['media']['gallery'] = array_values($galleryPaths);
        $content['media']['gallery_trash'] = array_values($trashPaths);
        return $content;
    }

    /**
     * Handle love stories with image uploads.
     */
    protected function handleLoveStories(Invitation $invitation, Request $request, array $content, $folderName): array
    {
        if (!$request->has('love_stories')) {
            return $content;
        }

        $stories = $request->love_stories;
        $filteredStories = [];

        foreach ($stories as $key => $story) {
            if ($request->hasFile("love_stories.{$key}.image")) {
                $file = $request->file("love_stories.{$key}.image");
                $ext = $this->safeImageExt($file);
                $filename = uniqid() . '_story.' . $ext;
                $path = $file->storeAs("public/invitations/{$folderName}", $filename);
                $story['image'] = str_replace('public/', 'storage/', $path);
            } elseif (isset($content['love_stories'][$key]['image'])) {
                $story['image'] = $content['love_stories'][$key]['image'];
            }

            if (!empty($story['year']) || !empty($story['title']) || !empty($story['story'])) {
                $filteredStories[] = $story;
            }
        }

        $content['love_stories'] = array_values($filteredStories);
        return $content;
    }

    /**
     * Resolve a safe image extension by trusting MIME-type detection
     * over the user-supplied filename. Defense-in-depth against
     * polyglot files like shell.jpg.php that bypass naive extension
     * checks. Falls back to 'jpg' if neither original nor guessed
     * extension is in the whitelist.
     */
    private function safeImageExt(\Illuminate\Http\UploadedFile $file): string
    {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        $guessed = strtolower((string) $file->guessExtension());
        if (in_array($guessed, $allowed, true)) {
            return $guessed;
        }

        $original = strtolower($file->getClientOriginalExtension());
        if (in_array($original, $allowed, true)) {
            return $original;
        }

        return 'jpg';
    }
}