<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Models\Plan;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Company::create([
            'name'=>"Al Ahram-Group",
            "name_manager"=>"Eng.Eslam Elgohry",
            "phone_manager"=>"01066201102",
        ]);

        Company::create([
            'name'=>"Al AlMohamedy",
            "name_manager"=>"Eng.Kareem",
            "phone_manager"=>"010690201102",
        ]);

        Company::create([
            'name'=>"Al Zahraa",
            "name_manager"=>"Eng.mohaemd",
            "phone_manager"=>"010778201102",
        ]);

    }
}
