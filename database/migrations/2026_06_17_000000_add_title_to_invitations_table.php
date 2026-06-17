<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add nullable `title` column to invitations table.
     *
     * Referenced by App\Http\Controllers\OrderController::store() and exposed
     * via the client dashboard Share Kit. Safe to run on existing rows since
     * the column is nullable.
     */
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('title')->nullable()->after('client_whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('title');
        });
    }
};
