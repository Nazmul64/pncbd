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
        Schema::create('user_informations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('full_name');
            $table->string('nid_number');
            $table->string('phone_number');
            $table->string('occupation');
            $table->text('current_address');
            $table->text('permanent_address');
            $table->text('loan_reason')->nullable();
            $table->string('selfie')->nullable();
            $table->string('nid_front')->nullable();
            $table->string('nid_back')->nullable();
            $table->string('other_document')->nullable();
            $table->text('signature')->nullable();
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->string('nominee_phone');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_informations');
    }
};
