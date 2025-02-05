<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Models\Plan;

class CompanySubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $company=Company::create([
            'name'=>"Al Ahram-Group",
            "name_manager"=>"Eng.Eslam Elgohry",
            "phone_manager"=>"01066201102",
        ]);

        $plan=Plan::find(1);

        $company->newPlanSubscription('main', $plan);

    }
}
