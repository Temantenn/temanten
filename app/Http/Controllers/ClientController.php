<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use App\Models\ActivityLog;
use App\Http\Requests\UpdateSettingsRequest;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\ImportGuestsRequest;
use App\Services\InvitationService;
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

    public function updateSettings(UpdateSettingsRequest $request, InvitationService $invitationService)
    {
        $user = auth()->user();
        $invitation = $user->invitations()->firstOrFail();

        $invitationService->updateSettings($invitation, $request);

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

    public function importGuests(ImportGuestsRequest $request)
    {
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

    public function storeGuest(StoreGuestRequest $request)
    {
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
