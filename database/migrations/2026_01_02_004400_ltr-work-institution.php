<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('book_authors', function (Blueprint $table) {
            $table->id();
            
            // Hapus penulis jika buku dihapus
            $table->foreignId('book_submission_id')->constrained('book_submissions')->onDelete('cascade');
            
            $table->string('name');
            $table->string('nidn_nip')->nullable(); // Nullable untuk penulis eksternal
            $table->string('affiliation');
            $table->string('email')->nullable();
            
            $table->integer('position')->default(1); // Urutan penulis 1, 2, 3
            $table->boolean('is_corresponding')->default(false); // Contact person utama
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('book_authors');
    }
};