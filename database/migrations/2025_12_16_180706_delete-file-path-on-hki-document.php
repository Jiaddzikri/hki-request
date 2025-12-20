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
        Schema::table('hki_proposal_documents', function (Blueprint $table) {
            $table->dropColumn('url_detail');
        });

        Schema::table('hki_proposals', function (Blueprint $table) {
            $table->string('url_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hki_proposals', function (Blueprint $table) {
            $table->dropColumn('url_detail');
        });

        Schema::table('hki_proposal_documents', function (Blueprint $table) {
            $table->string('url_detail');
        });
    }
};
