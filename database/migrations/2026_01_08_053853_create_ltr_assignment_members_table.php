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
    Schema::create('ltr_assignment_members', function (Blueprint $table) {
      $table->id();
      $table->uuid('ltr_assignment_request_id');
      $table->foreign('ltr_assignment_request_id')->references('id')->on('ltr_assignment_requests')->onDelete('cascade');

      // Data Anggota
      $table->string('email', 255);
      $table->string('name', 255);
      $table->string('nidn_nip_nim', 50)->nullable();
      $table->enum('faculty', ['FKIP', 'FIB', 'FEB', 'FISIP', 'FTI', 'FIKES'])->nullable();
      $table->string('academic_position', 255)->nullable(); // bisa isi custom
      $table->json('institutions'); // Array: dosen_unsap, mahasiswa_unsap, atau custom

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ltr_assignment_members');
  }
};
