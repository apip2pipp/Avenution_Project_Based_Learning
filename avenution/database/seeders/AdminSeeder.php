<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@avenution.com'],
            [
                'name' => 'Admin Avenution',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
        
        $admin->assignRole('admin');
        
        // Create sample regular user
        $user = User::firstOrCreate(
            ['email' => 'user@avenution.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
                'age' => 30,
                'gender' => 'male',
                'height' => 175.00,
                'weight' => 70.00,
            ]
        );
        
        $user->assignRole('user');
    }
}
