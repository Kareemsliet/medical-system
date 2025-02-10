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
           PermissionsTableSeeder::class,
           RolesTableSeeder::class,
           PermissionsRoles::class,
           CompaniesTableSeeder::class,
           UserTestSeeder::class,
           PlansTableSeeder::class,
           PlanFeaturesSeeder::class,
           SubscriptionsTableSeeder::class,
           MangmentsTableSeeder::class,
        ]);
    }
}
