<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Models\Plan;

class PlanFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $proPlan=Plan::find(1);

        $proPlan->features()->createMany([
            ['name' => 'max_users', 'value' => 10, 'sort_order' => 1],
            ['name' => 'max_branches', 'value' => 20, 'sort_order' => 2],
            ['name' => 'max_doctors', 'value' => 10, 'sort_order' => 3 ],
            ['name' => 'max_clinics', 'value' => 12, 'sort_order' => 4],
            ['name' => 'max_patient', 'value' => 10, 'sort_order' => 5]
        ]);

        $basicPlan=Plan::find(2);

        $basicPlan->features()->createMany([
            ['name' => 'max_users', 'value' => 4, 'sort_order' => 1],
            ['name' => 'max_branches', 'value' => 4, 'sort_order' => 2],
            ['name' => 'max_doctors', 'value' => 9, 'sort_order' => 3 ],
            ['name' => 'max_clinics', 'value' => 5, 'sort_order' => 4],
            ['name' => 'max_patient', 'value' => 5, 'sort_order' => 5]
        ]);

        $freePlan=Plan::find(3);

        $freePlan->features()->createMany([
            ['name' => 'max_users', 'value' => 2, 'sort_order' => 1],
            ['name' => 'max_branches', 'value' => 2, 'sort_order' => 2],
            ['name' => 'max_doctors', 'value' =>3 , 'sort_order' => 3 ],
            ['name' => 'max_clinics', 'value' => 6, 'sort_order' => 4],
            ['name' => 'max_patient', 'value' => 4, 'sort_order' => 5]
        ]);

    }
}
