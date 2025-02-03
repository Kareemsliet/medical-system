<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            [
                'name'=>'insert-clinic',
                'guard_name'=>"web",
                'routes'=>"clinics.store",
            ],
            [
                'name'=>'all-clinics',
                'guard_name'=>"web",
                'routes'=>"clinics.index",
            ],
            [
                'name'=>'show-clinic',
                'guard_name'=>"web",
                'routes'=>"clinics.show",
            ],
            [
                'name'=>'edit-clinic',
                'guard_name'=>"web",
                'routes'=>"clinics.update",
            ],
            [
                'name'=>'delete-clinic',
                'guard_name'=>"web",
                'routes'=>"clinics.destroy",
            ],
        ]);
    }
}
