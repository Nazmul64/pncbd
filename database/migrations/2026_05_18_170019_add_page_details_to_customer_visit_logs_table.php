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
        Schema::table('customer_visit_logs', function (Blueprint $table) {
            $table->string('page_name')->nullable()->after('user_agent');
            $table->text('page_url')->nullable()->after('page_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customer_visit_logs', function (Blueprint $table) {
            $table->dropColumn(['page_name', 'page_url']);
        });
    }
};
