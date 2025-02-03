<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser=User::create([
            'name'=>"admin",
            'email'=>"admin@gmail.com",
            "password"=>bcrypt("admin@345"),
        ]);

        $EmployeeUser=User::create([
            'name'=>"employee",
            'email'=>"employee@gmail.com",
            "password"=>bcrypt("admin@345"),
        ]);

        $adminUser->assignRole('admin');

        $EmployeeUser->assignRole('employee');
    }
}
