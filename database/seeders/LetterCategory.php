<?php

namespace Database\Seeders;

use App\Models\LtrCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterCategory extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $values = [
      'Sistem Penjaminan Mutu',
      'Penelitian dan Pengabdian kepada Masyarakat',
      'Pusat Data dan Informasi',
      'Akademik dan Kurikulum',
      'Keuangan',
      'Kepegawaian',
      'Sarana dan Prasarana',
      'Alumni dan Kemahasiswaan',
      'Kerjasama',
      'Perpustakaan'
    ];

    foreach ($values as $value) {
      LtrCategory::create([
        'category' => $value
      ]);
    }
  }
}
