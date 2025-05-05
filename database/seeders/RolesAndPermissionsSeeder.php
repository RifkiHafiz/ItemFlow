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
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'operator']);
        Role::firstOrCreate(['name' => 'user']);

        $operator = \App\Models\User::create([
            'username' => 'operator',
            'email' => 'operator@example.com',
            'password' => bcrypt('password123'),
            'full_name' => 'Operator Sistem'
        ]);

        $operator->assignRole('operator');

        $admin = \App\Models\User::create([
            'username' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'),
            'full_name' => 'Admin Sistem'
        ]);

        $admin->assignRole('admin');
    }
}
