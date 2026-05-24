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
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('payment_method'); // bikash, nagad, bank
            $table->string('account_holder_name')->nullable();
            $table->string('account_number');
            $table->string('bank_name')->nullable();
            $table->string('branch')->nullable();
            $table->double('amount');
            $table->integer('tenure'); // in months
            $table->double('interest_rate')->default(2.4); // flat barshik rate
            $table->double('interest_amount');
            $table->double('total_payable');
            $table->double('monthly_installment');
            $table->string('status')->default('pending'); // pending, approved, rejected
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};
