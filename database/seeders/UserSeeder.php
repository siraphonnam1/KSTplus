<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if the user with the specified username already exists
        $existingUser = User::where('username', 'admin')->first();

        if (!$existingUser) {
            // User doesn't exist, so create it
            $adminUser = User::create([
                'name' => 'AdminKST',
                'username' => 'admin',
                'password' => bcrypt('iddrivesadmin'), // Use bcrypt() to hash the password
                'agency' => '0',
                'brn' => '0',
                'dpm' => '0',
                'role' => 'admin',
                'icon' => '',
                'courses' => '',
                // ... any other user fields
            ]);

            if (!($adminUser->hasRole('admin'))) {
                $adminUser->assignRole('admin');
            }

            $this->command->info("User AdminKST created successfully.");
        } else {
            // User already exists, display a message
            $this->command->info("User AdminKST already exists.");
        }
    }
}
