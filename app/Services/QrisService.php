<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * EMVCo QRIS dynamic QR generator.
 *
 * Spec refs:
 * - EMVCo QR Code Specification (Merchant Presented Mode)
 * - Bank Indonesia QRIS Standard (National QR Code Standard)
 *
 * QRIS TLV structure:
 *   [id 2][len 2][value N]
 *
 * Common tags:
 *   00 Payload Format Indicator ("01")
 *   01 Point of Initiation Method ("11"=static, "12"=dynamic)
 *   26 Merchant Account Information (contains sub-tags 00..99)
 *      → 00 Globally Unique Identifier (e.g. "com.id.dana")
 *   52 Merchant Category Code (4 digits)
 *   53 Transaction Currency (360 = IDR)
 *   54 Transaction Amount (numeric, 2 decimal places for IDR)
 *   58 Country Code ("ID")
 *   59 Merchant Name
 *   60 Merchant City
 *   62 Additional Data Field (sub-tag 05 = Reference Label)
 *   63 CRC16-CCITT (XMODEM) — 4 uppercase hex chars
 *
 * CRC16:
 *   poly=0x1021, init=0xFFFF, no reflection, no XOR-out.
 */
class QrisService
{
    private const CRC_POLY = 0x1021;
    private const CRC_INIT = 0xFFFF;

    /**
     * Generate a dynamic QRIS string from a static master string by
     * injecting the transaction amount and reference label, then
     * re-signing the CRC.
     *
     * Returns the master string unchanged if amount <= 0 or master
     * is empty (graceful fallback for demo / unconfigured env).
     */
    public function generateDynamic(string $masterQris, float $amount, ?string $referenceLabel = null): string
    {
        if ($masterQris === '' || $amount <= 0) {
            return $masterQris;
        }

        try {
            $tlvs = $this->parse($masterQris);

            // Promote static (11) → dynamic (12) so e-wallets treat
            // the QR as one-shot with locked amount.
            if (($tlvs['01'] ?? null) === '11') {
                $tlvs['01'] = '12';
            }

            // Amount — IDR has 2 decimal places. "10000" → "10000.00".
            // Some e-wallets accept integers without decimal point, but
            // the EMVCo spec mandates 2dp; stick to spec.
            $tlvs['54'] = number_format($amount, 2, '.', '');

            // Reference label (tag 62 sub-tag 05) — used by payment
            // gateway webhook to identify the order.
            if ($referenceLabel !== null && $referenceLabel !== '') {
                $tlvs['62'] = $this->buildTag('05', $referenceLabel);
            }

            $serialized = $this->serialize($tlvs);

            // CRC is computed over the full payload INCLUDING the
            // CRC tag header (6304) but EXCLUDING the CRC value.
            // Per EMVCo spec.
            $payloadForCrc = $serialized . '6304';
            $crc = $this->crc16($payloadForCrc);

            return $serialized . '6304' . $crc;
        } catch (\Throwable $e) {
            // Log and return master as-is so payment page still loads;
            // better to show a static QR than a broken page.
            Log::warning('QRIS dynamic generation failed, falling back to master', [
                'amount' => $amount,
                'error'  => $e->getMessage(),
            ]);

            return $masterQris;
        }
    }

    /**
     * Parse a TLV string into an associative array keyed by tag id.
     */
    private function parse(string $tlv): array
    {
        $result = [];
        $pos = 0;
        $len = strlen($tlv);

        while ($pos < $len) {
            if ($pos + 4 > $len) {
                throw new \RuntimeException("Truncated TLV at pos {$pos}");
            }

            $tag = substr($tlv, $pos, 2);
            $lenBytes = substr($tlv, $pos + 2, 2);
            $valueLen = (int) $lenBytes;

            // Length validation
            if ($pos + 4 + $valueLen > $len) {
                throw new \RuntimeException("TLV value exceeds payload at pos {$pos} (tag {$tag})");
            }

            $value = substr($tlv, $pos + 4, $valueLen);
            $result[$tag] = $value;

            $pos += 4 + $valueLen;
        }

        // Strip the trailing CRC if present (last 8 chars: 6304XXXX)
        if (isset($result['63']) && strlen($result['63']) === 4) {
            unset($result['63']);
        }

        return $result;
    }

    /**
     * Serialize a tag=>value map back into TLV. Excludes CRC tag —
     * caller appends it after recomputing.
     *
     * @param array<string,string> $tlvs
     */
    private function serialize(array $tlvs): string
    {
        $out = '';

        // Tags must be serialized in ascending order per EMVCo spec.
        ksort($tlvs, SORT_STRING);

        foreach ($tlvs as $tag => $value) {
            if ($tag === '63') {
                continue; // caller handles CRC
            }
            $out .= $this->buildTag($tag, $value);
        }

        return $out;
    }

    private function buildTag(string $tag, string $value): string
    {
        $len = strlen($value);
        if ($len > 99) {
            throw new \RuntimeException("TLV value for tag {$tag} exceeds 99 bytes");
        }

        return $tag . str_pad((string) $len, 2, '0', STR_PAD_LEFT) . $value;
    }

    /**
     * CRC16-CCITT (XMODEM): poly 0x1021, init 0xFFFF, no reflection,
     * no XOR-out. Returns 4 uppercase hex chars.
     */
    private function crc16(string $data): string
    {
        $crc = self::CRC_INIT;
        $len = strlen($data);

        for ($i = 0; $i < $len; $i++) {
            $crc ^= ord($data[$i]) << 8;

            for ($j = 0; $j < 8; $j++) {
                if (($crc & 0x8000) !== 0) {
                    $crc = (($crc << 1) ^ self::CRC_POLY) & 0xFFFF;
                } else {
                    $crc = ($crc << 1) & 0xFFFF;
                }
            }
        }

        return strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
    }
}