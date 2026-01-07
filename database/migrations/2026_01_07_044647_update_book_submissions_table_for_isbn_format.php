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
    Schema::table('book_submissions', function (Blueprint $table) {
      // Drop kolom yang tidak dipakai
      $table->dropColumn(['category', 'scientific_field', 'synopsis', 'size']);

      // Jenis Permohonan ISBN
      $table->enum('isbn_request_type', ['LEPAS', 'JILID'])->after('title');

      // Media Terbitan
      $table->enum('publication_media', ['CETAK', 'DIGITAL_PDF', 'DIGITAL_EPUB', 'AUDIO_BOOK', 'AUDIO_VISUAL'])->after('isbn_request_type');

      // Kelompok Pembaca
      $table->enum('reader_group', ['ANAK', 'DEWASA', 'SEMUA_UMUR'])->after('publication_media');

      // Jenis Pustaka
      $table->enum('library_type', ['FIKSI', 'NON_FIKSI'])->after('reader_group');

      // Kategori Jenis Pustaka
      $table->enum('library_category', ['TERJEMAHAN', 'NON_TERJEMAHAN'])->after('library_type');

      // KDT (Katalog Dalam Terbitan)
      $table->boolean('has_kdt')->default(false)->after('library_category');

      // Perkiraan Terbit
      $table->string('estimated_publish_month')->nullable()->after('has_kdt');
      $table->year('estimated_publish_year')->nullable()->after('estimated_publish_month');

      // Tempat Terbit
      $table->string('province')->nullable()->after('estimated_publish_year');
      $table->string('city')->nullable()->after('province');

      // Distributor
      $table->string('distributor')->nullable()->after('city');

      // Deskripsi/Abstrak
      $table->text('description')->nullable()->after('distributor');

      // Jumlah Halaman & Ukuran
      $table->integer('total_pages')->nullable()->after('description');
      $table->decimal('book_height_cm', 5, 2)->nullable()->after('total_pages');

      // Edisi & Seri
      $table->string('edition')->nullable()->after('book_height_cm');
      $table->string('series')->nullable()->after('edition');

      // Ilustrasi
      $table->boolean('has_illustration')->default(false)->after('series');

      // URL Link Publikasi
      $table->string('publication_url')->nullable()->after('has_illustration');

      // Rename submitted_at untuk konsistensi
      $table->timestamp('submitted_at')->nullable()->after('status');
      $table->timestamp('published_at')->nullable()->after('submitted_at');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::table('book_submissions', function (Blueprint $table) {
      // Restore kolom lama
      $table->string('category')->nullable();
      $table->string('scientific_field')->nullable();
      $table->text('synopsis')->nullable();
      $table->string('size')->nullable();

      // Drop kolom baru
      $table->dropColumn([
        'isbn_request_type',
        'publication_media',
        'reader_group',
        'library_type',
        'library_category',
        'has_kdt',
        'estimated_publish_month',
        'estimated_publish_year',
        'province',
        'city',
        'distributor',
        'description',
        'total_pages',
        'book_height_cm',
        'edition',
        'series',
        'has_illustration',
        'publication_url',
        'submitted_at',
        'published_at',
      ]);
    });
  }
};
