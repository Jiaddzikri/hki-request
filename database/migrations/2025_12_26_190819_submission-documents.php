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
    Schema::create('ltr_submission_documents', function (Blueprint $table) {
        $table->id();
        $table->foreignId('submission_id')->constrained('ltr_submissions')->cascadeOnDelete();
        
        $table->string('type');
        $table->string('file_path');
        $table->string('original_name');
        $table->integer('file_size');
        
        $table->string('file_hash')->nullable(); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ltr_submission_documents');
    }
};
