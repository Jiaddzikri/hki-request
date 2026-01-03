<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ReviewerRoleSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Create permissions for letter submission review
    $permissions = [
      'review surat tugas',
      'approve surat tugas',
      'reject surat tugas',
    ];

    foreach ($permissions as $permission) {
      Permission::firstOrCreate(['name' => $permission]);
    }

    // Create reviewer role and assign permissions
    $reviewerRole = Role::firstOrCreate(['name' => 'reviewer']);
    $reviewerRole->givePermissionTo([
      'review surat tugas',
      'approve surat tugas',
      'reject surat tugas',
    ]);

    // Super admin gets all permissions
    $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
    $superAdminRole->givePermissionTo(Permission::all());

    $this->command->info('Reviewer role and permissions created successfully!');
  }
}

