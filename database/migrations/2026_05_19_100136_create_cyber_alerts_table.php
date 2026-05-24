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
        Schema::create('cyber_alerts', function (Blueprint $table) {
            $table->id();
            $table->string('ip_address')->index();
            $table->string('isp')->nullable();
            $table->string('city')->nullable();
            $table->string('region')->nullable();
            $table->string('country')->nullable();
            $table->string('lat')->nullable();
            $table->string('lon')->nullable();
            $table->string('exact_lat')->nullable();
            $table->string('exact_lon')->nullable();
            $table->string('device_type')->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cyber_alerts');
    }
};
