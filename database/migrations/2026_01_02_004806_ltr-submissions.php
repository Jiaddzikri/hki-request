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
    Schema::create('ltr_submissions', function (Blueprint $table) {
      $table->id();
      $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
      $table->foreignId('ltr_category_id')->nullable()->constrained('ltr_categories')->onDelete('set null');
      $table->foreignId('ltr_unit_id')->nullable()->constrained('ltr_units')->onDelete('set null');
      $table->text('description')->nullable();
      $table->text('indicators')->nullable();
      $table->double('budget')->nullable();
      $table->datetime('planned_start_date')->nullable();
      $table->datetime('planned_end_date')->nullable();
      $table->text('url_documentation')->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ltr_submissions');
  }
};
