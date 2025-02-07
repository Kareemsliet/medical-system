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
            'email'=>"admin@gmail.com",
            "password"=>bcrypt("admin@345"),
            "company_id"=>1,
        ]);

        $EmployeeUser=User::create([
            'email'=>"employee@gmail.com",
            "password"=>bcrypt("admin@345"),
            "company_id"=>1,
        ]);

        $doctorUser=User::create([
            'email'=>"doctor@gmail.com",
            "password"=>bcrypt("doctor@345"),
            "company_id"=>1,
        ]);

        $adminUser->assignRole('admin');

        $EmployeeUser->assignRole('employee');

        $doctorUser->assignRole('doctor');
    }
}
