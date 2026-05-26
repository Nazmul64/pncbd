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
        Schema::table('generalsettings', function (Blueprint $table) {
            if (!Schema::hasColumn('generalsettings', 'cert_signature')) {
                $table->string('cert_signature')->nullable();
            }
            if (!Schema::hasColumn('generalsettings', 'approved_seal')) {
                $table->string('approved_seal')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('generalsettings', function (Blueprint $table) {
            if (Schema::hasColumn('generalsettings', 'cert_signature')) {
                $table->dropColumn('cert_signature');
            }
            if (Schema::hasColumn('generalsettings', 'approved_seal')) {
                $table->dropColumn('approved_seal');
            }
        });
    }
};
