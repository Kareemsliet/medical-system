<?php

namespace Database\Seeders;

use App\Models\ExpenseCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExpensesCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ExpenseCategory::insert([
            ['name' => 'الرواتب'],
            ['name' => 'المرافق'],
            ['name' => 'المستلزمات الطبية'],
            ['name' => 'مستلزمات المكتب'],
            ['name' => 'الصيانة'],
            ['name' => 'التسويق'],
            ['name' => 'التأمين'],
            ['name' => 'الإيجار'],
            ['name' => 'متنوع'],
        ]);
    }
}
