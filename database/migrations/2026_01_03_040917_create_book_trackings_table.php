<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::create('book_trackings', function (Blueprint $table) {
      $table->id();
      $table->foreignId('book_submission_id')->constrained('book_submissions')->onDelete('cascade');

      $table->string('status'); // Status pada saat itu (Snapshot)
      $table->text('description')->nullable(); // Pesan tambahan (misal: "Dikembalikan ke penulis karena format salah")

      // Siapa yang mengubah status? (Bisa null jika by system)
      $table->foreignId('actor_id')->nullable()->constrained('users');

      $table->timestamps();
    });
  }

  public function down(): void
  {
    Schema::dropIfExists('book_trackings');
  }
};