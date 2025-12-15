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
        Schema::create('hki_proposal_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('hki_proposal_id')->constrained('hki_proposals')->cascadeOnDelete();
            $table->string('name');
            $table->string('file_path');
            $table->string('mime_type');
            $table->integer('file_size');
            $table->string('file_hash', 64);

            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hki_proposal_documents');
    }
};
