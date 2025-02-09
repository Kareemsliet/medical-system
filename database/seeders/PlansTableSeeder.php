<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Laravelcm\Subscriptions\Interval;
use Laravelcm\Subscriptions\Models\Plan;

class PlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Pro',
            'description' => 'Pro plan',
            'price' => 100,
            'signup_fee' => 10,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 10,
            'trial_interval' => Interval::DAY->value,
            'sort_order' => 1,
            'currency' => 'EGP',
        ]);

        Plan::create([
            'name' => 'Basic',
            'description' => 'Basic plan',
            'price' => 50,
            'signup_fee' => 10,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 10,
            'trial_interval' => Interval::DAY->value,
            'sort_order' => 2,
            'currency' => 'EGP',
        ]);
        
        Plan::create([
            'name' => 'Free',
            'description' => 'Free plan',
            'price' => 0.0,
            'signup_fee' => 0.0,
            'invoice_period' => 1,
            'invoice_interval' => Interval::MONTH->value,
            'trial_period' => 10,
            'trial_interval' => Interval::DAY->value,
            'sort_order' => 3,
            'currency' => 'EGP',
        ]);

    }
}
