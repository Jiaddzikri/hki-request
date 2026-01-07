<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_submission_id')->constrained('book_submissions')->onDelete('cascade');
            
            // FULL_DRAFT, COVER, STATEMENT_LETTER, PROOFREAD_RESULT
            $table->string('type'); 
            
            $table->string('file_path');
            $table->string('file_name'); // Nama asli file
            $table->integer('file_size'); // Dalam bytes
            $table->integer('version')->default(1); // Versi revisi
            
            // Siapa yang upload? (Bisa Penulis, Editor, atau Layouter)
            $table->foreignId('uploaded_by')->constrained('users');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_files');
    }
};