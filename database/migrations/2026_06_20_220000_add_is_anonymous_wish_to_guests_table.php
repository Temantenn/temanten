<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * RSVP pollution fix:
 * - Without ?to= token or matching name, anonymous users could
 *   submit any name → create new guest entry → pollute dashboard
 *   headcount + admin Klien Aktif list.
 *
 * Add `is_anonymous_wish` flag:
 * - false (default): real guest from client-imported Excel / manual entry
 * - true: anonymous wish submitted via public invitation form,
 *   with no matching guest in the list. Still shown in wishes/comments,
 *   but EXCLUDED from dashboard guest list + headcount stats.
 */
return new class extends Migration
{
    public function up(): void
{
        Schema::table('guests', function (Blueprint $table) {
            $table->boolean('is_anonymous_wish')
                ->default(false)
                ->after('jumlah_tamu')
                ->index();
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropIndex(['is_anonymous_wish']);
            $table->dropColumn('is_anonymous_wish');
        });
    }
};
