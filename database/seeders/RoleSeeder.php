<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Permission::create(['name' => 'submit proposal']);
        Permission::create(['name' => 'review proposal']);
        Permission::create(['name' => 'manage users']);


        $roleDosen = Role::create(['name' => 'dosen']);
        $roleDosen->givePermissionTo('submit proposal');

        $roleReviewer = Role::create(['name' => 'reviewer']);
        $roleReviewer->givePermissionTo(['review proposal', 'submit proposal']);

        $roleAdmin = Role::create(['name' => 'super-admin']);
        $roleAdmin->givePermissionTo(Permission::all());

        $myUser = User::where('email', '220660121093@student.unsap.ac.id')->first();
        if ($myUser) {
            $myUser->assignRole('super-admin');
            $myUser->assignRole('reviewer');
        }
    }
}
