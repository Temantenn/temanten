<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class QrisService
{
    /**
     * Generate a demo dynamic QRIS string from a master static QRIS.
     * 
     * NOTE:
     * - For production, replace with actual dynamic QRIS provider API.
     * - Currently returns the master string unchanged.
     */
    public function generateDynamic(string $masterQris, int $amount): string
    {
        // TODO (P0-5): integrate payment gateway here;
        // do NOT inline raw API keys in source code.

        Log::info('Dynamic QRIS requested (demo mode)', [
            'amount'   => $amount,
            'provider' => config('temanten.qris_provider', 'demo'),
        ]);

        return $masterQris;
    }
}