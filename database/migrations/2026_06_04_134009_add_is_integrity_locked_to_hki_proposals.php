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
        Schema::table('hki_proposals', function (Blueprint $table) {
            $table->boolean('is_integrity_locked')->default(false)->after('status')
                ->comment('Dikunci otomatis ketika verifikasi audit hash chain mendeteksi manipulasi data.');
            $table->timestamp('integrity_locked_at')->nullable()->after('is_integrity_locked')
                ->comment('Waktu penguncian terakhir oleh sistem verifikasi integritas.');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hki_proposals', function (Blueprint $table) {
            $table->dropColumn(['is_integrity_locked', 'integrity_locked_at']);
        });
    }
};
