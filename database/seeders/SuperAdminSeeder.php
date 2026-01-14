<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        // Create Super Admin role
        $superAdminRole = Role::create(['name' => 'super-admin']);

        // Create permissions
        $permissions = [
            'manage users',
            'manage stocks',
            'view dashboard',
        ];

        foreach ($permissions as $perm) {
            $permission = Permission::create(['name' => $perm]);
            $superAdminRole->givePermissionTo($permission);
        }

        // Assign Super Admin role to admin@example.com user
        $user = User::where('email', 'admin@example.com')->first();
        if ($user) {
            $user->assignRole($superAdminRole);
            $this->command->info('Super Admin role and permissions assigned to admin@example.com');
        } else {
            $this->command->warn('User admin@example.com not found.');
        }
    }
}
