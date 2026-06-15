<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->foreignId('theme_id')->constrained('themes');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('slug')->unique();
            $table->string('client_whatsapp');
            $table->enum('status', ['pending', 'active', 'completed', 'cancelled'])->default('pending');

            $table->dateTime('event_date');
            $table->json('content');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};