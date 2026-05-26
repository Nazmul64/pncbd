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
        Schema::table('hrm_employees', function (Blueprint $table) {
            $table->string('email')->nullable()->after('phone');
            $table->string('blood_group')->nullable()->after('nid_number');
            $table->date('expire_date')->nullable()->after('join_date');
            $table->string('id_card_front')->nullable()->after('status');
            $table->string('id_card_back')->nullable()->after('id_card_front');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hrm_employees', function (Blueprint $table) {
            $table->dropColumn(['email', 'blood_group', 'expire_date', 'id_card_front', 'id_card_back']);
        });
    }
};
