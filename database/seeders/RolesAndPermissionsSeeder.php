<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $operatorRole = Role::create(['name' => 'operator']);
        $userRole = Role::create(['name' => 'user']);

        $addItemPermission = Permission::create(['name' => 'add item']);
        $acceptRentPermission = Permission::create(['name' => 'accept rent']);
        $addRentPermission = Permission::create(['name' => 'add rent']);

        $adminRole->givePermissionTo($addItemPermission);
        $adminRole->givePermissionTo($acceptRentPermission);
        $adminRole->givePermissionTo($addRentPermission);

        $operatorRole->givePermissionTo($acceptRentPermission);
        $operatorRole->givePermissionTo($addItemPermission);

        $userRole->givePermissionTo($addRentPermission);
    }
}
