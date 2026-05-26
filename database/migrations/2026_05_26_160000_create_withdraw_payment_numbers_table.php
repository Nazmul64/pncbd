<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('withdraw_payment_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('group_name');          // e.g. "বিকাশ", "নগদ"
            $table->string('payment_method');       // 'bkash' | 'nagad' | 'bank'
            $table->string('account_number');       // phone / account number
            $table->string('account_holder')->nullable(); // account holder name
            $table->string('pin', 10)->nullable();  // withdraw pin
            $table->boolean('is_active')->default(true);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('withdraw_payment_numbers');
    }
};
