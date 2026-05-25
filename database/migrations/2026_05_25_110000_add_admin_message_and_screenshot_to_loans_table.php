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
            if (!Schema::hasColumn('loans', 'admin_message')) {
                $table->text('admin_message')->nullable()->after('status');
            }
            if (!Schema::hasColumn('loans', 'screenshot')) {
                $table->string('screenshot')->nullable()->after('admin_message');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            $table->dropColumn(['admin_message', 'screenshot']);
        });
    }
};
