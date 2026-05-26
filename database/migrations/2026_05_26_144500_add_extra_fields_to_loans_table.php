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
        Schema::table('loans', function (Blueprint $table) {
            $table->double('admin_fee')->nullable()->after('status');
            $table->string('staff_name')->nullable()->after('admin_fee');
            $table->string('staff_phone')->nullable()->after('staff_name');
            $table->string('signature_image')->nullable()->after('staff_phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['admin_fee', 'staff_name', 'staff_phone', 'signature_image']);
        });
    }
};
