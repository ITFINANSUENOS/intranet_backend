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
        $this->call([
            // Llama a tu seeder de Company aquí
            RolesAndPermissionsSeeder::class,
            CompanySeeder::class,
            PositionSeeder::class,
            RegionalSeeder::class,
            CostCenterSeeder::class,
            UserSeeder::class,
        ]);
    }
}
