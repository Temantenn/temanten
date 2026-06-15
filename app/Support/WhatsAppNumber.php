<?php

namespace App\Support;

final class WhatsAppNumber
{
    private const INDONESIAN_MOBILE_PATTERN = '/^628[0-9]{8,11}$/';

    public static function normalize(mixed $raw): ?string
    {
        if (!self::isFilled($raw) || !is_scalar($raw)) {
            return null;
        }

        $value = trim((string) $raw);

        if (!preg_match('/^\+?[0-9\s().-]+$/', $value)) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $value);

        if ($digits === '') {
            return null;
        }

        if (str_starts_with($digits, '0')) {
            $digits = '62' . substr($digits, 1);
        } elseif (str_starts_with($digits, '8')) {
            $digits = '62' . $digits;
        }

        return preg_match(self::INDONESIAN_MOBILE_PATTERN, $digits) ? $digits : null;
    }

    public static function isFilled(mixed $raw): bool
    {
        if ($raw === null) {
            return false;
        }

        return !is_string($raw) || trim($raw) !== '';
    }

    public static function isValid(mixed $raw): bool
    {
        return self::normalize($raw) !== null;
    }

    public static function validationRule(string $message = 'Nomor WhatsApp tidak valid. Gunakan nomor Indonesia aktif, contoh: 081234567890.'): \Closure
    {
        return function (string $attribute, mixed $value, \Closure $fail) use ($message): void {
            if (self::isFilled($value) && self::normalize($value) === null) {
                $fail($message);
            }
        };
    }
}