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
    Schema::create('hki_reviews', function (Blueprint $table) {
      $table->id();
      $table->uuid('hki_proposal_id');
      $table->foreign('hki_proposal_id')->references('id')->on('hki_proposals')->onDelete('cascade');
      $table->foreignId('reviewer_id')->constrained('users')->onDelete('cascade');
      $table->text('review_notes')->nullable();
      $table->enum('decision', ['approved', 'rejected', 'revision']);
      $table->timestamp('reviewed_at');
      $table->timestamps();

      $table->index(['hki_proposal_id', 'reviewed_at']);
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('hki_reviews');
  }
};
