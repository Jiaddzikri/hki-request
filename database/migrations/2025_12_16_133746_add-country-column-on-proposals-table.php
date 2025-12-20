<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('hki_proposals', function (Blueprint $table) {
            $table->string('publication_country')->nullable()->after('publication_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hki_proposals', function (Blueprint $table) {
            $table->dropColumn('publication_country');
        });
    }
};
