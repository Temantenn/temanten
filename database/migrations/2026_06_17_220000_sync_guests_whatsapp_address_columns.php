<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Sync guests schema dengan model + form + controller expectations.
     *
     * Existing codebase (model $fillable, StoreGuestRequest, ClientController,
     * dashboard.blade.php view) pakai:
     *   - `whatsapp`  → DB punya `phone_number` (rename)
     *   - `address`   → ga ada di DB (add)
     *   - `jumlah_tamu` → di $fillable only (skip, no consumer)
     */
    public function up(): void
    {
        // Rename phone_number → whatsapp biar match dgn seluruh codebase
        if (Schema::hasColumn('guests', 'phone_number') && !Schema::hasColumn('guests', 'whatsapp')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->renameColumn('phone_number', 'whatsapp');
            });
        }

        // Tambah address column kalau belum ada (dipake StoreGuestRequest + form)
        if (!Schema::hasColumn('guests', 'address')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->string('address', 500)->nullable()->after('category');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('guests', 'address')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->dropColumn('address');
            });
        }

        if (Schema::hasColumn('guests', 'whatsapp') && !Schema::hasColumn('guests', 'phone_number')) {
            Schema::table('guests', function (Blueprint $table) {
                $table->renameColumn('whatsapp', 'phone_number');
            });
        }
    }
};