<?php

namespace App\Imports;

use App\Models\Guest;
use App\Support\WhatsAppNumber;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GuestsImport implements ToModel, WithHeadingRow, WithChunkReading
{
    private $invitation_id;
    private $totalRows = 0;

    public function __construct($invitation_id)
    {
        $this->invitation_id = $invitation_id;
    }

    public function model(array $row)
    {
        if (!isset($row['nama']) || trim($row['nama']) === '') {
            return null;
        }

        $this->totalRows++;

        return new Guest([
            'invitation_id' => $this->invitation_id,
            'name'          => $row['nama'],
            'category'      => $row['kategori'] ?? 'Reguler',
            'slug'          => Str::slug($row['nama']) . '-' . Str::random(4),
            'whatsapp'      => WhatsAppNumber::normalize($row['whatsapp'] ?? null),
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function getRowCount(): int
    {
        return $this->totalRows;
    }
}