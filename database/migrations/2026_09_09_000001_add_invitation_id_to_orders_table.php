<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'invitation_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->foreignId('invitation_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('invitations')
                    ->nullOnDelete();
                $table->unique('invitation_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'invitation_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropUnique(['invitation_id']);
                $table->dropConstrainedForeignId('invitation_id');
            });
        }
    }
};
