<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::findOrCreate('admin', 'web');
        $userRole = Role::findOrCreate('user', 'web');

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@avenution.com'],
            [
                'name' => 'Admin Avenution',
                'username' => 'admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        if (! $admin->username) {
            $admin->username = 'admin';
            $admin->save();
        }

        $admin->syncRoles([$adminRole]);
        
        // Create sample regular user
        $user = User::firstOrCreate(
            ['email' => 'user@avenution.com'],
            [
                'name' => 'John Doe',
                'username' => 'user',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'age' => 30,
                'gender' => 'male',
                'height' => 175.00,
                'weight' => 70.00,
            ]
        );

        if (! $user->username) {
            $user->username = 'user';
            $user->save();
        }

        $user->syncRoles([$userRole]);
    }
}
