<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Setup Roles and Permissions
        $this->call([
            RoleSeeder::class,
            ReviewerRoleSeeder::class,
        ]);

        // 2. Setup Data Types and Categories
        $this->call([
            HKITypeSeeder::class,
            LetterCategory::class,
            LetterUnit::class,
        ]);

        // 3. Create Test User
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
