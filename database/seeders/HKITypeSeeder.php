<?php

namespace Database\Seeders;

use App\Models\HKIType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HKITypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            HkiType::query()->delete();
        } catch (\Exception $e) {
         
        }
        $musik = HkiType::create([
            'name' => 'Karya Rekaman Suara / Musik',
            'requires_claims' => false
        ]);

        $musik->children()->createMany([
            ['name' => 'Musik Dangdut', 'requires_claims' => false],
            ['name' => 'Musik Hip-hop / Rap', 'requires_claims' => false],
            ['name' => 'Musik Pop', 'requires_claims' => false],
            ['name' => 'Musik Rock / Metal', 'requires_claims' => false],
            ['name' => 'Musik Tradisional / Daerah', 'requires_claims' => false],
            ['name' => 'Instrumental', 'requires_claims' => false],
        ]);

        $tulis = HkiType::create([
            'name' => 'Karya Tulis',
            'requires_claims' => false
        ]);

        $tulis->children()->createMany([
            ['name' => 'Buku / Modul Ajar', 'requires_claims' => false],
            ['name' => 'Program Komputer / Software', 'requires_claims' => false],
            ['name' => 'Naskah Drama / Film', 'requires_claims' => false],
            ['name' => 'Atlas / Peta', 'requires_claims' => false],
        ]);

        $paten = HkiType::create([
            'name' => 'Paten',
            'requires_claims' => true
        ]);

        $paten->children()->createMany([
            ['name' => 'Paten Biasa (Invensi Baru)', 'requires_claims' => true],
            ['name' => 'Paten Sederhana (Pengembangan)', 'requires_claims' => true],
        ]);
        
        HkiType::create(['name' => 'Desain Industri', 'requires_claims' => false]);
        HKIType::create(['name' => 'Merek Dagang', 'requires_claims' => false]);
    
    }
}
