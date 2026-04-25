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
      // Add letter_number column after status
      // Format: 309/A/LPPM-UNSAP/XII/2025
      $table->string('letter_number', 100)->nullable()->after('status');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('ltr_assignment_requests', function (Blueprint $table) {
      $table->dropColumn('letter_number');
    });
  }
};
