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
    Schema::table('book_authors', function (Blueprint $table) {
      // Kategori Kepengarangan
      $table->enum('role_category', [
        'PENULIS',
        'KOMIKUS',
        'PENERJEMAH',
        'ILUSTRATOR',
        'EDITOR',
        'MURAJAAH',
        'REVIEWER',
        'FOTOGRAFER'
      ])->default('PENULIS')->after('book_submission_id');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('book_authors', function (Blueprint $table) {
      $table->dropColumn('role_category');
    });
  }
};
