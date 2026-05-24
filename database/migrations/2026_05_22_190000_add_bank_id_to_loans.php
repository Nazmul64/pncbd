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
            // Add bank_id column if it does not exist
            if (!Schema::hasColumn('loans', 'bank_id')) {
                $table->foreignId('bank_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('banks')
                    ->onDelete('set null');
            }
            // Remove old bank_name column if it exists
            if (Schema::hasColumn('loans', 'bank_name')) {
                $table->dropColumn('bank_name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loans', function (Blueprint $table) {
            // Restore bank_name column
            if (!Schema::hasColumn('loans', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('account_number');
            }
            // Drop foreign key and column
            if (Schema::hasColumn('loans', 'bank_id')) {
                $table->dropForeign(['bank_id']);
                $table->dropColumn('bank_id');
            }
        });
    }
};
