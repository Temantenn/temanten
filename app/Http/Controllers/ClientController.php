<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invitation = Invitation::where('user_id', $user->id)->first();

        $guests = [];
        $totalGuests = 0;
        $hadir = 0;
        $tidakHadir = 0;
        $pending = 0;

        if ($invitation) {
            $guests = $invitation->guests()->orderBy('created_at', 'desc')->get();
            $totalGuests = $guests->count();
            $hadir = $guests->where('rsvp_status', 'hadir')->count();
            $tidakHadir = $guests->where('rsvp_status', 'tidak_hadir')->count();
            $pending = $guests->whereIn('rsvp_status', ['pending', null])->count();
        }

        return view('client.dashboard', compact(
            'invitation',
            'guests',
            'totalGuests',
            'hadir',
            'tidakHadir',
            'pending'
        ));
    }

    public function settings()
    {
        $user = Auth::user();
        $invitation = Invitation::where('user_id', $user->id)->firstOrFail();

        return view('client.settings', compact('invitation'));
    }

    public function updateSettings(Request $request)
    {
        $user = auth()->user();
        $invitation = $user->invitations()->firstOrFail();

        $content = $invitation->content ?? [];
        $folderName = $invitation->id;

        $uploadFile = function ($inputName, $subFolder) use ($request, $folderName) {
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $filename = uniqid() . '_' . $inputName . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs("public/invitations/{$folderName}", $filename);
                return str_replace('public/', 'storage/', $path);
            }
            return null;
        };

        $content['mempelai']['pria']['nama'] = $request->groom_name;
        $content['mempelai']['pria']['panggilan'] = $request->groom_nickname;
        $content['mempelai']['pria']['ayah'] = $request->groom_father;
        $content['mempelai']['pria']['ibu'] = $request->groom_mother;
        $content['mempelai']['pria']['instagram'] = $request->groom_instagram;

        $content['mempelai']['wanita']['nama'] = $request->bride_name;
        $content['mempelai']['wanita']['panggilan'] = $request->bride_nickname;
        $content['mempelai']['wanita']['ayah'] = $request->bride_father;
        $content['mempelai']['wanita']['ibu'] = $request->bride_mother;
        $content['mempelai']['wanita']['instagram'] = $request->bride_instagram;

        $content['quote'] = $request->quote;

        $content['acara']['akad']['judul'] = $request->akad_title;
        $content['acara']['akad']['waktu'] = $request->akad_datetime;
        $content['acara']['akad']['tempat'] = $request->akad_location;
        $content['acara']['akad']['alamat'] = $request->akad_address;
        $content['acara']['akad']['maps'] = $request->akad_map_link;
        // Wilayah Akad
        if ($request->akad_province_name) {
            $content['acara']['akad']['wilayah'] = [
                'province' => $request->akad_province_name,
                'regency'  => $request->akad_regency_name,
                'district' => $request->akad_district_name,
                'village'  => $request->akad_village_name,
            ];
        }

        $content['acara']['resepsi']['judul'] = $request->resepsi_title;
        $content['acara']['resepsi']['waktu'] = $request->resepsi_datetime;
        $content['acara']['resepsi']['tempat'] = $request->resepsi_location;
        $content['acara']['resepsi']['alamat'] = $request->resepsi_address;
        $content['acara']['resepsi']['maps'] = $request->resepsi_map_link;
        // Wilayah Resepsi
        if ($request->resepsi_province_name) {
            $content['acara']['resepsi']['wilayah'] = [
                'province' => $request->resepsi_province_name,
                'regency'  => $request->resepsi_regency_name,
                'district' => $request->resepsi_district_name,
                'village'  => $request->resepsi_village_name,
            ];
        }

        $content['amplop']['bank_name'] = $request->bank_name;
        $content['amplop']['account_number'] = $request->bank_number;
        $content['amplop']['account_holder'] = $request->bank_holder;
        $content['amplop']['alamat_kado'] = $request->gift_address;
        $content['amplop']['maps_kado'] = $request->gift_map_link;
        // Wilayah Kado
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

        if ($path = $uploadFile('groom_photo', $folderName)) {
            $content['mempelai']['pria']['foto'] = $path;
        }
        if ($path = $uploadFile('bride_photo', $folderName)) {
            $content['mempelai']['wanita']['foto'] = $path;
        }
        if ($path = $uploadFile('cover_image', $folderName)) {
            $content['media']['cover'] = $path;
        }
        if ($path = $uploadFile('og_image', $folderName)) {
            $content['media']['og_image'] = $path;
        }
        if ($path = $uploadFile('music_file', $folderName)) {
            $content['media']['music'] = $path;
        }
        if ($path = $uploadFile('qris_image', $folderName)) {
            $content['amplop']['qris_image'] = $path;
        }

        // Normalisasi: pastikan array numeric 0-based sebelum proses delete
        $galleryPaths = array_values($content['media']['gallery'] ?? []);

        if ($request->has('delete_gallery')) {
            $toDelete = array_map('intval', (array) $request->delete_gallery);
            $toDelete = array_unique($toDelete);

            foreach ($toDelete as $idx) {
                if (!array_key_exists($idx, $galleryPaths)) {
                    continue;
                }
                $path = $galleryPaths[$idx];

                // Hanya hapus file fisik bila path lokal (bukan URL eksternal)
                if (is_string($path) && $path !== '' && !preg_match('#^https?://#i', $path)) {
                    // Path disimpan sebagai "storage/invitations/..." → mapping ke disk "public/invitations/..."
                    $storagePath = Str::startsWith($path, 'storage/')
                        ? 'public/' . Str::after($path, 'storage/')
                        : (Str::startsWith($path, 'public/') ? $path : null);

                    if ($storagePath) {
                        try {
                            if (Storage::exists($storagePath)) {
                                Storage::delete($storagePath);
                            }
                        } catch (\Throwable $e) {
                            Log::warning('Gagal menghapus file gallery', [
                                'path'  => $storagePath,
                                'error' => $e->getMessage(),
                            ]);
                        }
                    }
                }

                unset($galleryPaths[$idx]);
            }
            // Reindex supaya urutan rapi
            $galleryPaths = array_values($galleryPaths);
        }

        if ($request->hasFile('gallery_photos')) {
            foreach ($request->file('gallery_photos') as $photo) {
                $filename = uniqid() . '_gallery.' . $photo->getClientOriginalExtension();
                $path = $photo->storeAs("public/invitations/{$folderName}", $filename);
                $galleryPaths[] = str_replace('public/', 'storage/', $path);
            }
        }
        $content['media']['gallery'] = array_values($galleryPaths);

        $content['media']['video_link'] = $request->video_link;

        if ($request->has('love_stories')) {
            $stories = $request->love_stories;
            $filteredStories = [];
            foreach ($stories as $key => $story) {
                if ($request->hasFile("love_stories.{$key}.image")) {
                    $file = $request->file("love_stories.{$key}.image");
                    $filename = uniqid() . '_story.' . $file->getClientOriginalExtension();
                    $path = $file->storeAs("public/invitations/{$folderName}", $filename);
                    $story['image'] = str_replace('public/', 'storage/', $path);
                } elseif (isset($content['love_stories'][$key]['image'])) {
                    $story['image'] = $content['love_stories'][$key]['image'];
                }
                
                // Only save if it has at least one filled field
                if (!empty($story['year']) || !empty($story['title']) || !empty($story['story'])) {
                    $filteredStories[] = $story;
                }
            }
            $content['love_stories'] = array_values($filteredStories);
        }

        if (isset($content['acara']['resepsi']['waktu'])) {
            $invitation->event_date = Carbon::parse($content['acara']['resepsi']['waktu']);
        } elseif (isset($content['acara']['akad']['waktu'])) {
            $invitation->event_date = Carbon::parse($content['acara']['akad']['waktu']);
        }

        $invitation->content = $content;
        $invitation->save();

        // Log perubahan settings undangan
        ActivityLog::record('info', 'invitation.settings_updated', $invitation, [
            'updated_by' => auth()->user()->email,
        ]);

        return back()->with('success', 'Data undangan berhasil diperbarui!');
    }

    public function downloadTemplate()
    {
        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=template_tamu.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['Nama Tamu', 'Nomor WA', 'Kategori', 'Alamat'];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            fputcsv($file, ['Budi Santoso', '081234567890', 'Teman Kerja', 'Jakarta']);
            fputcsv($file, ['Siti Aminah', '089876543210', 'Keluarga', 'Bandung']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importGuests(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt,xlsx,xls|max:2048'
        ]);

        $user = auth()->user();
        $invitation = $user->invitations()->firstOrFail();

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = [];

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getPathname(), 'r');
            fgetcsv($handle);
            while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                if (array_filter($data)) {
                    $rows[] = $data;
                }
            }
            fclose($handle);
        } else {
            try {
                $import = new class implements ToArray {
                    public function array(array $array)
                    {
                        return $array;
                    }
                };

                $data = Excel::toArray($import, $file);

                if (count($data) > 0) {
                    $sheet1 = $data[0];
                    array_shift($sheet1);
                    $rows = $sheet1;
                }
            } catch (\Exception $e) {
                return back()->withErrors([
                    'file' => 'Gagal membaca Excel: ' . $e->getMessage()
                ]);
            }
        }

        $count = 0;

        foreach ($rows as $row) {
            $name = $row[0] ?? null;

            if ($name && trim($name) !== '') {
                $slug = Str::slug($name) . '-' . Str::random(4);

                $invitation->guests()->create([
                    'name' => $name,
                    'whatsapp' => $row[1] ?? null,
                    'category' => $row[2] ?? 'Umum',
                    'address' => $row[3] ?? null,
                    'slug' => $slug,
                    'rsvp_status' => 'pending'
                ]);

                $count++;
            }
        }

        return back()->with('success', "Berhasil mengimpor {$count} data tamu!");
    }

    public function storeGuest(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'nullable|string|max:20',
            'category' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $user = auth()->user();
        $invitation = $user->invitations()->firstOrFail();

        $slug = \Illuminate\Support\Str::slug($request->name) . '-' . \Illuminate\Support\Str::random(4);

        $invitation->guests()->create([
            'name' => $request->name,
            'whatsapp' => $request->whatsapp,
            'category' => $request->category ?? 'Umum',
            'address' => $request->address,
            'slug' => $slug,
            'rsvp_status' => 'pending'
        ]);

        return back()->with('success', 'Berhasil menambahkan tamu: ' . $request->name);
    }
    public function deleteGuest(Guest $guest)
    {
        $user = auth()->user();
        $invitation = $user->invitations()->firstOrFail();

        // Pastikan tamu memang milik undangan user ini
        if ($guest->invitation_id !== $invitation->id) {
            abort(403, 'Akses ditolak.');
        }

        $name = $guest->name;
        $guest->delete();

        return back()->with('success', "Tamu \"{$name}\" berhasil dihapus.");
    }

    public function exportGuests(Invitation $invitation)
    {
        if ($invitation->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $guests = $invitation->guests()->orderBy('created_at', 'desc')->get();

        $filename = "daftar_tamu_{$invitation->slug}_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Nama', 'Kategori', 'WhatsApp', 'Status Kehadiran', 'Ucapan', 'Tanggal Input'];

        $callback = function() use($guests, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($guests as $guest) {
                // Formatting the RSVP status to be more readable
                $status = 'Pending';
                if ($guest->rsvp_status == 'hadir') $status = 'Hadir';
                if ($guest->rsvp_status == 'tidak_hadir') $status = 'Tidak Hadir';
                if ($guest->rsvp_status == 'ragu') $status = 'Ragu-ragu';

                $row = [
                    $guest->name,
                    $guest->category ?? '-',
                    $guest->whatsapp ?? '-',
                    $status,
                    $guest->comment ?? '-',
                    $guest->created_at->format('Y-m-d H:i:s')
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
