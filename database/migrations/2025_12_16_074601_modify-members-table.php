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
        Schema::table('hki_proposal_members', function (Blueprint $table) {
            $table->string('nik', 30)->nullable();
            $table->string('npwp', 50)->nullable();
            $table->string('email')->nullable();
            $table->text('detail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hki_proposal_members', function(Blueprint $table) {
            $table->dropColumn('nik');
            $table->dropColumn('npwp');
            $table->dropColumn('email');
            $table->dropColumn('detail');
        });
    }
};
