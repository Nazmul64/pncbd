<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ── Admin ↔ Staff chat threads ─────────────────────────────────────────
        Schema::create('staff_chats', function (Blueprint $table) {
            $table->id();
            // staff_id = User.id যে employee/manager রোলে আছে
            $table->unsignedBigInteger('staff_id');
            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamp('last_activity_at')->nullable();
            $table->timestamps();

            $table->unique('staff_id'); // প্রতি staff-এর একটাই thread
        });

        // ── Messages in each thread ────────────────────────────────────────────
        Schema::create('staff_chat_messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('staff_chat_id');
            $table->foreign('staff_chat_id')->references('id')->on('staff_chats')->onDelete('cascade');

            // sender_type: 'admin' | 'staff'
            $table->enum('sender_type', ['admin', 'staff']);
            $table->unsignedBigInteger('sender_id')->nullable(); // User.id
            $table->text('message');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff_chat_messages');
        Schema::dropIfExists('staff_chats');
    }
};
