<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionsRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminPermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic','all-clinics','show-clinic','insert-doctor','edit-doctor','delete-doctor','all-doctors','show-doctor',"all-patients","delete-patient","show-patient","insert-patient","edit-patient","insert-employee","delete-employee","edit-employee","all-employees",'show-employee',"insert-doctor-action","edit-doctor-action","delete-doctor-action","show-doctor-action","all-doctor-actions","edit-password"])->get();

        $employeePermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic','insert-doctor','edit-doctor','delete-doctor',"delete-patient","insert-patient","edit-patient","insert-doctor-action","edit-doctor-action","delete-doctor-action","edit-password"])->get();
        
        $doctorPermissions=Permission::whereIn('name',["edit-password"])->get();

        $patientPermissions=Permission::whereIn('name',["edit-password"])->get();

        $admin=Role::findByName('admin');

        $doctor=Role::findByName('doctor');

        $employee=Role::findByName('employee');

        $patient=Role::findByName('patient');

        $admin->syncPermissions($adminPermissions);

        $employee->syncPermissions($employeePermissions);

        $doctor->syncPermissions($doctorPermissions);

        $patient->syncPermissions($patientPermissions);
    }
}
