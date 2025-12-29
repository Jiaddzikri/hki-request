<?php

namespace Database\Seeders;

use App\Models\LTRAcademicPeriod;
use App\Models\LTRGrantScheme;
use Illuminate\Database\Seeder;

class GrantMasterSeeder extends Seeder
{
    public function run(): void
    {
        $periode = LTRAcademicPeriod::create([
            'name' => 'Hibah Internal 2025 (Ganjil)',
            'year' => 2025,
            'start_date' => '2025-01-01',
            'end_date' => '2025-03-30',
            'is_active' => true
        ]);

        LTRGrantScheme::create([
            'name' => 'Penelitian Dosen Pemula',
            'code' => 'PDP',
            'max_budget' => 15000000,
            'requires_external_partner' => false,
            'requires_student_member' => true,
        ]);
        LTRGrantScheme::create([
            'name' => 'Penelitian Terapan Unggulan',
            'code' => 'PTU',
            'max_budget' => 75000000,
            'requires_external_partner' => true,
            'requires_student_member' => true,
        ]);
    }
}