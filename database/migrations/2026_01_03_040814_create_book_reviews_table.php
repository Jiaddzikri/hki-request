<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_submission_id')->constrained('book_submissions')->onDelete('cascade');
            
            // Reviewer diambil dari tabel Users
            $table->foreignId('reviewer_id')->constrained('users');
            
            $table->text('review_notes')->nullable();
            $table->string('review_file_path')->nullable(); // File naskah yang dicoret-coret
            
            // ACCEPTED, REVISION_MAJOR, REVISION_MINOR, REJECTED
            $table->string('decision')->nullable();
            
            $table->date('deadline_at')->nullable();
            $table->timestamp('reviewed_at')->nullable(); // Kapan selesai review
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_reviews');
    }
};