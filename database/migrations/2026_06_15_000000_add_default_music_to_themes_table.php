<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('themes', 'default_music')) {
            Schema::table('themes', function (Blueprint $table) {
                $table->string('default_music')->nullable()->after('thumbnail');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('themes', 'default_music')) {
            Schema::table('themes', function (Blueprint $table) {
                $table->dropColumn('default_music');
            });
        }
    }
};
