<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasColumn('invitations', 'deleted_at')) {
            Schema::table('invitations', function (Blueprint $table) {
                $table->softDeletes()->after('updated_at');
            });
        }

        if (!Schema::hasColumn('guests', 'deleted_at')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->softDeletes()->after('updated_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('invitations', 'deleted_at')) {
            Schema::table('invitations', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }

        if (Schema::hasColumn('guests', 'deleted_at')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->dropSoftDeletes();
            });
        }
    }
};