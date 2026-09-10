<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Invitation;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AutoDeleteInvitations extends Command
{
    protected $signature = 'invitation:cleanup';

    protected $description = 'Menghapus permanen undangan & file yang sudah lewat 3 hari dari event_date';

    public function handle()
    {
        $this->info('Memulai pembersihan data lama...');
        $limitDate = Carbon::now()->subDays(3);
        $expiredInvitations = Invitation::where('event_date', '<', $limitDate)->get();

        $count = 0;

        foreach ($expiredInvitations as $invitation) {
            $directoryPath = "public/invitations/{$invitation->id}";
            
            if (Storage::exists($directoryPath)) {
                Storage::deleteDirectory($directoryPath);
                $this->info("- Folder foto undangan ID {$invitation->id} dihapus.");
            }
            // Invitation uses SoftDeletes; cleanup is explicitly the permanent
            // retention job, so remove the row and its guests permanently.
            $invitation->forceDelete();
            
            $this->info("- Data database ID {$invitation->id} dihapus.");
            $count++;
        }

        if ($count > 0) {
            $this->info("SUKSES: Berhasil menghapus permanen {$count} undangan.");
        } else {
            $this->info("INFO: Tidak ada undangan kadaluarsa yang ditemukan.");
        }
    }
}
