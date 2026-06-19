<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * QR Check-in feature:
     * - checkin_token: random 64-char unique string, embedded in QR code per tamu.
     * - checked_in_at: timestamp when staff confirms guest at venue (nullable).
     *
     * Tokens di-generate di boot() model juga untuk guest baru, jadi migration ini
     * cuma backfill existing rows.
     */
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Nullable dulu, backfill, lalu set unique (di loop terpisah biar SQLite/MySQL兼容)
            $table->string('checkin_token', 64)->nullable()->after('slug');
            $table->timestamp('checked_in_at')->nullable()->after('rsvp_status');
        });

        // Backfill existing guests yang belum punya token
        $rows = DB::table('guests')->whereNull('checkin_token')->select('id')->get();
        foreach ($rows as $row) {
            // Retry sampai dapet token yang unique
            do {
                $token = Str::random(48); // 48 char base64url-ish = ~288 bits entropy
            } while (DB::table('guests')->where('checkin_token', $token)->exists());

            DB::table('guests')->where('id', $row->id)->update(['checkin_token' => $token]);
        }

        // Sekarang semua rows punya token, tambah unique index
        Schema::table('guests', function (Blueprint $table) {
            $table->unique('checkin_token');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropUnique(['checkin_token']);
            $table->dropColumn(['checkin_token', 'checked_in_at']);
        });
    }
};