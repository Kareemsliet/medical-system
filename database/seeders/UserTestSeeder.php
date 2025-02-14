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
            "email_verified_at"=>now(),
        ]);

        $adminUser->employee()->create([
            "name"=>"admin",
        ]);

        $adminUser->assignRole('admin');

    }
}
