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
    Schema::create('ltr_assignment_requests', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

      // Ajuan untuk
      $table->enum('assignment_type', ['penelitian', 'pkm', 'penunjang', 'seminar_workshop']);

      // Data Pengaju
      $table->string('full_name', 255);
      $table->string('nidn', 50);
      $table->enum('faculty', ['FKIP', 'FIB', 'FEB', 'FISIP', 'FTI', 'FIKES']);
      $table->json('academic_positions'); // Array: asisten_ahli, lektor, lektor_kepala, guru_besar

      // Periode
      $table->date('start_date');
      $table->date('end_date');
      $table->string('academic_year', 20); // e.g., 2025/2026

      // Detail Kegiatan
      $table->string('institution_name', 500);
      $table->text('institution_address');
      $table->string('research_title', 500);
      $table->decimal('estimated_budget', 15, 2)->nullable();

      // Penanggung Jawab
      $table->string('leader_name', 255);
      $table->string('pic_name', 255);

      // Dokumen & Publikasi
      $table->string('report_file_path')->nullable();
      $table->string('publication_link', 500)->nullable();

      // Status
      $table->enum('status', ['DRAFT', 'SUBMITTED', 'APPROVED', 'REJECTED', 'REVISION'])->default('DRAFT');

      $table->timestamps();
      $table->softDeletes();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ltr_assignment_requests');
  }
};
