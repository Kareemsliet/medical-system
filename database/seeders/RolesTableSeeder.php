<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            [
                "name"=>"system_manager",
                "guard_name"=>"web",
            ],
            [
                "name"=> "admin",
                "guard_name"=>"web",
            ],
            [
                "name"=> "patient",
                "guard_name"=>"web",
            ],
            [
                "name"=> "doctor",
                "guard_name"=>"web",
            ],
            [
                "name"=> "employee",
                "guard_name"=>"web",
            ]
        ]);
    }
}
