<?php

namespace Database\Seeders;

use App\Models\Company;
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
            "url"=>"http://localhost:8000",
        ]);
    }
}
