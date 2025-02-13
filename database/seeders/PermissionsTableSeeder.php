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
                'name'=>'all-patients',
                'guard_name'=>"web",
                'routes'=>"patients.index",
            ],
            [
                'name'=>'delete-patient',
                'guard_name'=>"web",
                'routes'=>"patients.destroy",
            ],
            [
                'name'=>'show-patient',
                'guard_name'=>"web",
                'routes'=>"patients.show",
            ],
            [
                'name'=>'insert-patient',
                'guard_name'=>"web",
                'routes'=>"patients.store",
            ],
            [
                'name'=>'edit-patient',
                'guard_name'=>"web",
                'routes'=>"patients.update",
            ],
            [
                'name'=>'edit-employee',
                'guard_name'=>"web",
                'routes'=>"employees.update",
            ],
            [
                'name'=>'insert-employee',
                'guard_name'=>"web",
                'routes'=>"employees.store",
            ],
            [
                'name'=>'delete-employee',
                'guard_name'=>"web",
                'routes'=>"employees.destroy",
            ],
            [
                'name'=>'show-employee',
                'guard_name'=>"web",
                'routes'=>"employees.show",
            ],
            [
                'name'=>'all-employees',
                'guard_name'=>"web",
                'routes'=>"employees.index",
            ],
            [
                'name'=>'edit-password',
                'guard_name'=>"web",
                'routes'=>"profile.password.update",
            ],
        ]);
    }
}
