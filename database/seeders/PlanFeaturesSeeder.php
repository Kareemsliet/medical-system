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
            ['name' => 'max_users', 'value' => 2, 'sort_order' => 1],
            ['name' => 'max_doctors', 'value' => 3, 'sort_order' => 3 ],
            ['name' => 'max_clinics', 'value' => 4, 'sort_order' => 4],
            ['name' => 'max_patients', 'value' => 2, 'sort_order' => 5]
        ]);

        $basicPlan=Plan::find(2);

        $basicPlan->features()->createMany([
            ['name' => 'max_users', 'value' => 4, 'sort_order' => 1],
            ['name' => 'max_doctors', 'value' => 5, 'sort_order' => 3 ],
            ['name' => 'max_clinics', 'value' => 3, 'sort_order' => 4],
            ['name' => 'max_patients', 'value' => 2, 'sort_order' => 5]
        ]);

        $freePlan=Plan::find(3);

        $freePlan->features()->createMany([
            ['name' => 'max_users', 'value' => 2, 'sort_order' => 1],
            ['name' => 'max_doctors', 'value' =>3 , 'sort_order' => 3 ],
            ['name' => 'max_clinics', 'value' => 6, 'sort_order' => 4],
            ['name' => 'max_patients', 'value' => 4, 'sort_order' => 5]
        ]);

    }
}
