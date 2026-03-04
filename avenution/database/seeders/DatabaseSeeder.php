<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed in order: Roles -> Admins -> Foods
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            FoodSeeder::class,
        ]);
    }
}
