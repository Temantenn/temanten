<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Theme;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OrderService
{
    /**
     * Calculate price for a theme using promo price when available.
     */
    public function calculatePrice(Theme $theme): int
    {
        return (int) $theme->effective_price;
    }

    /**
     * Generate a unique 3-digit payment code with collision check (kept small per QRIS).
     */
    public function generateUniqueCode(): int
    {
        for ($attempt = 0; $attempt < 20; $attempt++) {
            $code = random_int(100, 999);

            $exists = Order::where('unique_code', $code)
                ->where(function ($q) {
                    $q->whereIn('status', ['pending'])
                        ->where('expired_at', '>', Carbon::now())
                        ->orWhereIn('status', ['paid']);
                })
                ->exists();

            if (!$exists) {
                return $code;
            }
        }

        // Fallback deterministic
        return (int) (Carbon::now()->timestamp % 900) + 100;
    }

    /**
     * Persist order with retry loop to survive unique constraint races.
     */
    public function createOrderWithUniqueCode(array $attributes, ?int $basePrice = null): Order
    {
        $base = $attributes;

        for ($i = 0; $i < 10; $i++) {
            $base['unique_code'] = $this->generateUniqueCode();

            if ($basePrice !== null) {
                // Total tagihan = harga flat (ditampilkan ke user).
                // unique_code disimpan terpisah & hanya di-inject ke nominal QRIS
                // untuk kebutuhan auto-verify. UI tidak menampilkan unique_code.
                $base['total_amount'] = $basePrice;
            }

            try {
                return Order::create($base);
            } catch (QueryException $e) {
                if (!$this->isOrderUniqueCollision($e)) {
                    throw $e;
                }

                if ($this->isOrderNumberCollision($e)) {
                    $base['order_number'] = $this->generateOrderNumber();
                }
            }
        }

        throw new \RuntimeException('Gagal membuat order: unique code tidak tersedia.');
    }

    private function isOrderUniqueCollision(QueryException $e): bool
    {
        $message = $e->getMessage();
        $sqlState = (string) ($e->errorInfo[0] ?? '');

        if (!in_array($sqlState, ['23000', '23505'], true) && !str_contains($message, 'UNIQUE constraint failed')) {
            return false;
        }

        return str_contains($message, 'orders_unique_code_unique')
            || str_contains($message, 'orders.unique_code')
            || str_contains($message, 'orders_order_number_unique')
            || str_contains($message, 'orders.order_number');
    }

    private function isOrderNumberCollision(QueryException $e): bool
    {
        $message = $e->getMessage();

        return str_contains($message, 'orders_order_number_unique')
            || str_contains($message, 'orders.order_number');
    }

    /**
     * Generate a unique order number with a short random suffix.
     */
    public function generateOrderNumber(): string
    {
        $prefix = 'TRX';
        $date = Carbon::now()->format('Ymd');
        $rand = strtoupper(Str::random(6));

        $candidate = "{$prefix}-{$date}-{$rand}";

        // Ensure uniqueness (very rare collision)
        $tries = 0;
        while (Order::where('order_number', $candidate)->exists() && $tries < 5) {
            $rand = strtoupper(Str::random(6));
            $candidate = "{$prefix}-{$date}-{$rand}";
            $tries++;
        }

        return $candidate;
    }
}