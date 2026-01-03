<?php

namespace Database\Seeders;

use App\Models\LtrUnit;
use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LetterUnit extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $values = [
      'Rektorat',
      'Fakultas Keguruan dan Ilmu Pendidikan',
      'Fakultas Ilmu Budaya',
      'Fakultas Ilmu Sosial dan Ilmu Politik',
      'Fakultas Ekonomi dan Bisnis',
      'Fakultas Ilmu Kesehatan',
      'Fakultas Teknologi Informasi'
    ];

    foreach ($values as $value) {
      LtrUnit::create([
        'unit' => $value
      ]);
    }
  }
}
