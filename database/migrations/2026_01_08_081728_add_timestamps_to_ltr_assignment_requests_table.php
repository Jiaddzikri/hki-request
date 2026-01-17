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
    Schema::table('ltr_assignment_requests', function (Blueprint $table) {
      $table->timestamp('submitted_at')->nullable()->after('status');
      $table->timestamp('reviewed_at')->nullable()->after('submitted_at');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('ltr_assignment_requests', function (Blueprint $table) {
      $table->dropColumn(['submitted_at', 'reviewed_at']);
    });
  }
};
