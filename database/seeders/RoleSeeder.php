<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::create(['name' => 'admin']);

        $adminUser = User::create([
            'name' => 'AdminKST',
            'username' => 'admin', // Make sure 'username' is a valid column in your users table
            'password' => 'iddrivesadmin', // Replace with a secure password
            'agency' => '0',
            'brn' => '0',
            'dpm' => '0',
            'role' => 'admin',
            'icon' => null,
            'courses'=> null,
            // ... any other user fields
        ]);

        $adminUser->assignRole($adminRole);

    }
}
