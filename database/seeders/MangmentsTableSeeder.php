<?php

namespace Database\Seeders;

use App\Models\Management;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class MangmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Management::create([
            'email'=>"admin@gmail.com",
            "password"=>bcrypt("admin@345"),
            "name"=>"admin",
        ]);
    }
}
