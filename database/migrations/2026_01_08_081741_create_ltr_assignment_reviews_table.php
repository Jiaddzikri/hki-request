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
    Schema::create('ltr_assignment_reviews', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->foreignUuid('assignment_request_id')->constrained('ltr_assignment_requests')->onDelete('cascade');
      $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
      $table->enum('decision', ['APPROVED', 'REJECTED', 'REVISION'])->default('REVISION');
      $table->text('notes')->nullable();
      $table->timestamp('reviewed_at')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ltr_assignment_reviews');
  }
};
