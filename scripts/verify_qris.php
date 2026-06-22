<?php
/**
 * EMVCo QRIS dynamic QR verification script.
 *
 * Run from a Laravel project root:
 *   php scripts/verify_qris.php
 *
 * Exits 0 on all-pass, 1 on any failure. Output is "[OK] description" /
 * "[FAIL] description" for easy grep + CI integration.
 *
 * This script intentionally does NOT boot Laravel — it just tests the
 * pure-PHP TLV + CRC logic so you can verify before wiring up to a model.
 *
 * If you want to test against your actual app's QrisService:
 *   require 'vendor/autoload.php';
 *   $app = require 'bootstrap/app.php';
 *   $svc = $app->make(\App\Services\QrisService::class);
 *
 * What this proves:
 *   1. Tag 54 (amount) is correctly encoded as "X.XX"
 *   2. Tag 01 (initiation method) is promoted 11 -> 12
 *   3. Tag 62 sub-tag 05 carries the reference label
 *   4. Tag 63 (CRC) is valid for the payload (roundtrip recompute)
 *   5. Empty master returns empty (no crash)
 *   6. Zero amount returns master unchanged
 *   7. Tags are in ascending order (EMVCo spec requirement)
 */

require __DIR__ . '/../vendor/autoload.php';

use App\Services\QrisService;

// ---------------------------------------------------------------------------
// Build a syntactically valid master QRIS TLV (don't fabricate — compute!)
// ---------------------------------------------------------------------------
$baseSub = '0014ID.CO.QRIS.WWW0118936006010';         // 25 chars (sub-tag 00 GUI)
$acquirerId = '0101' . str_pad('1234567890', 15, '0', STR_PAD_LEFT);  // 19 chars
$merchant26Val = $baseSub . $acquirerId;               // 44 chars total for tag 26 value

$ref = 'TRX-20260621-ABC';
$refSubVal = $ref;
$refSub = '05' . str_pad((string) strlen($refSubVal), 2, '0', STR_PAD_LEFT) . $refSubVal;  // sub-tag 05 inside tag 62

$tlvs = [
    '00' => '01',
    '01' => '11',
    '26' => $merchant26Val,
    '52' => '0000',
    '53' => '360',
    '58' => 'ID',
    '59' => 'TOKO TEST',
    '60' => 'JAKARTA',
    '62' => $refSub,
];

$payload = '';
foreach ($tlvs as $tag => $val) {
    $payload .= $tag . str_pad((string) strlen($val), 2, '0', STR_PAD_LEFT) . $val;
}

$payloadForCrc = $payload . '6304';
$crc = 0xFFFF;
for ($i = 0; $i < strlen($payloadForCrc); $i++) {
    $crc ^= ord($payloadForCrc[$i]) << 8;
    for ($j = 0; $j < 8; $j++) {
        $crc = ($crc & 0x8000) ? (($crc << 1) ^ 0x1021) & 0xFFFF : ($crc << 1) & 0xFFFF;
    }
}
$crcHex = strtoupper(str_pad(dechex($crc), 4, '0', STR_PAD_LEFT));
$masterQris = $payload . '6304' . $crcHex;

echo "Master: $masterQris\n";
echo 'Master length: ' . strlen($masterQris) . "\n\n";

// ---------------------------------------------------------------------------
// Run the service
// ---------------------------------------------------------------------------
$svc = new QrisService();
$result = $svc->generateDynamic($masterQris, 123456.78, 'TRX-20260621-XYZ');

echo "=== Service result ===\n";
echo "Output: $result\n";
echo 'Length: ' . strlen($result) . "\n\n";

// ---------------------------------------------------------------------------
// Parse the output for assertion
// ---------------------------------------------------------------------------
$parsed = [];
$pos = 0;
while ($pos < strlen($result)) {
    $tag = substr($result, $pos, 2);
    $tagLen = (int) substr($result, $pos + 2, 2);
    $val = substr($result, $pos + 4, $tagLen);
    $parsed[$tag] = $val;
    $pos += 4 + $tagLen;
}

echo "Parsed tags:\n";
foreach ($parsed as $tag => $val) {
    echo "  $tag: $val\n";
}
echo "\n";

$pass = 0;
$fail = 0;
function check(string $desc, bool $ok): void {
    global $pass, $fail;
    if ($ok) { echo "[OK] $desc\n"; $pass++; }
    else     { echo "[FAIL] $desc\n"; $fail++; }
}

// 1. Amount encoding
check('Amount tag 54 = 123456.78', ($parsed['54'] ?? '') === '123456.78');

// 2. Initiation method promoted to dynamic
check('Initiation method tag 01 = 12 (dynamic)', ($parsed['01'] ?? '') === '12');

// 3. Reference label in tag 62 sub 05
check('Reference label TRX-20260621-XYZ in tag 62', isset($parsed['62']) && str_contains($parsed['62'], 'TRX-20260621-XYZ'));

// 4. CRC16 roundtrip
$gotCrc = substr($result, -4);
$payloadNoCrc = substr($result, 0, -4);
$crc2 = 0xFFFF;
for ($i = 0; $i < strlen($payloadNoCrc); $i++) {
    $crc2 ^= ord($payloadNoCrc[$i]) << 8;
    for ($j = 0; $j < 8; $j++) {
        $crc2 = ($crc2 & 0x8000) ? (($crc2 << 1) ^ 0x1021) & 0xFFFF : ($crc2 << 1) & 0xFFFF;
    }
}
$expectedCrc = strtoupper(str_pad(dechex($crc2), 4, '0', STR_PAD_LEFT));
check("CRC16-CCITT (XMODEM) valid (got=$gotCrc, expected=$expectedCrc)", $gotCrc === $expectedCrc);

// 5. Empty master returns empty
$r2 = $svc->generateDynamic('', 1000);
check('Empty master returns empty', $r2 === '');

// 6. Zero amount returns master unchanged
$r3 = $svc->generateDynamic($masterQris, 0);
check('Zero amount returns master unchanged', $r3 === $masterQris);

// 7. Tags in ascending order
$tagsInOrder = [];
$pos = 0;
while ($pos < strlen($result)) {
    $tagsInOrder[] = substr($result, $pos, 2);
    $tagLen = (int) substr($result, $pos + 2, 2);
    $pos += 4 + $tagLen;
}
$sorted = $tagsInOrder;
sort($sorted);
check(
    'Tags sorted ascending: ' . implode(',', $tagsInOrder),
    $tagsInOrder === $sorted
);

echo "\n=== SUMMARY: $pass passed, $fail failed ===\n";
exit($fail > 0 ? 1 : 0);
