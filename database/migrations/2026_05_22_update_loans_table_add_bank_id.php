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
            // Add bank_id column if it doesn't exist
            if (!Schema::hasColumn('loans', 'bank_id')) {
                $table->foreignId('bank_id')->nullable()->after('user_id')->constrained('banks')->onDelete('set null');
            }

            // Drop bank_name column if it exists
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
            // Add back bank_name if we need to rollback
            if (!Schema::hasColumn('loans', 'bank_name')) {
                $table->string('bank_name')->nullable()->after('account_number');
            }

            // Drop bank_id if it exists
            if (Schema::hasColumn('loans', 'bank_id')) {
                $table->dropForeignKeyIfExists(['bank_id']);
                $table->dropColumn('bank_id');
            }
        });
    }
};
