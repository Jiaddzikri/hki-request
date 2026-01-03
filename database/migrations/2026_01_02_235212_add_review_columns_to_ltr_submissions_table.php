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
    Schema::table('ltr_submissions', function (Blueprint $table) {
      $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('url_documentation');
      $table->foreignId('reviewer_id')->nullable()->after('status')->constrained('users')->onDelete('set null');
      $table->text('review_notes')->nullable()->after('reviewer_id');
      $table->timestamp('reviewed_at')->nullable()->after('review_notes');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('ltr_submissions', function (Blueprint $table) {
      $table->dropForeign(['reviewer_id']);
      $table->dropColumn(['status', 'reviewer_id', 'review_notes', 'reviewed_at']);
    });
  }
};
