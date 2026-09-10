<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('guests', 'jumlah_tamu')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->unsignedTinyInteger('jumlah_tamu')->nullable()->after('rsvp_status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('guests', 'jumlah_tamu')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->dropColumn('jumlah_tamu');
            });
        }
    }
};
