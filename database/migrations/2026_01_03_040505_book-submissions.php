<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_submissions', function (Blueprint $table) {
            $table->id();
            // Relasi ke User (Pengusul)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            $table->string('title');
            
            // Enum disimpan sebagai string agar fleksibel jika ada penambahan kategori
            $table->string('category'); // MONOGRAF, BUKU_AJAR, dll
            $table->string('scientific_field'); // Bidang Ilmu
            
            $table->text('synopsis')->nullable();
            $table->integer('page_estimation')->default(0);
            
            $table->string('size'); // A5, B5, UNESCO, CUSTOM
            
            // Data ISBN (Nullable karena di awal belum ada)
            $table->string('isbn')->nullable();
            $table->string('e_isbn')->nullable();
            $table->year('publication_year')->nullable();
            
            // Tambahan untuk cek plagiasi
            $table->float('similarity_score')->nullable(); 
            
            // Status Workflow (DRAFT, SUBMITTED, REVIEW_PROCESS, dll)
            $table->string('status')->default('DRAFT')->index();
            
            $table->timestamps();
            $table->softDeletes(); // Penting: Agar data tidak hilang permanen jika terhapus
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_submissions');
    }
};