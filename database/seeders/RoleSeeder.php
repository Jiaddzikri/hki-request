<?php

namespace Database\Seeders;

use App\Models\User;
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

        // Bypass account for explicit Reviewer testing
        $reviewerUser = User::firstOrCreate(
            ['email' => 'email-reviewer@unsap.ac.id'],
            [
                'name' => 'Akun Reviewer (Testing)',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
                'email_verified_at' => now(),
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'two_factor_confirmed_at' => null,
            ]
        );
        $reviewerUser->assignRole('reviewer');
    }
}
