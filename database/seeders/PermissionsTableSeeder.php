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
            [
                'name'=>'insert-doctor',
                'guard_name'=>"web",
                'routes'=>"doctors.store",
            ],
            [
                'name'=>'show-doctor',
                'guard_name'=>"web",
                'routes'=>"doctors.show",
            ],
            [
                'name'=>'delete-doctor',
                'guard_name'=>"web",
                'routes'=>"doctors.destroy",
            ],
            [
                'name'=>'all-doctors',
                'guard_name'=>"web",
                'routes'=>"doctors.index",
            ],
            [
                'name'=>'edit-doctor',
                'guard_name'=>"web",
                'routes'=>"doctors.update",
            ],
            [
                'name'=>'insert-doctor-action',
                'guard_name'=>"web",
                'routes'=>"actions.store",
            ],
            [
                'name'=>'edit-doctor-action',
                'guard_name'=>"web",
                'routes'=>"actions.update",
            ],
            [
                'name'=>'delete-doctor-action',
                'guard_name'=>"web",
                'routes'=>"actions.destroy",
            ],
            [
                'name'=>'all-doctor-actions',
                'guard_name'=>"web",
                'routes'=>"actions.index",
            ],
            [
                'name'=>'show-doctor-action',
                'guard_name'=>"web",
                'routes'=>"actions.show",
            ],
            [
                'name'=>'edit-profile',
                'guard_name'=>"web",
                'routes'=>"profile.update",
            ],
        ]);
    }
}
