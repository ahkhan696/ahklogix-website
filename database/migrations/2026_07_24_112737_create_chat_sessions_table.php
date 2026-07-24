<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('chat_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 36)->unique();
            $table->string('ip_address', 45)->nullable();
            $table->string('driver', 50)->nullable();
            $table->unsignedSmallInteger('turns')->default(0);
            $table->json('messages')->nullable();
            $table->string('intent_detected', 50)->nullable();
            $table->boolean('handoff_triggered')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_sessions');
    }
};
