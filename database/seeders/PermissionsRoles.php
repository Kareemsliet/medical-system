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
        $systemManagerPermissions=Permission::whereIn("name",['insert-company','show-company','all-companies','delete-company','insert-employee'])->get();

        $adminPermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic','all-clinics','show-clinic','insert-doctor','edit-doctor','delete-doctor','all-doctors','show-doctor',"all-patients","delete-patient","show-patient","insert-patient","edit-patient","insert-employee","delete-employee","edit-employee","all-employees",'show-employee',"edit-company"])->get();

        $employeePermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic','insert-doctor','edit-doctor','delete-doctor',"delete-patient","insert-patient","edit-patient"])->get();
        
        $doctorPermissions=Permission::whereIn('name',["insert-doctor-action","edit-doctor-action","delete-doctor-action","show-doctor-action","all-doctor-actions","edit-profile"])->get();

        $systemManager=Role::findByName("system_manager");

        $admin=Role::findByName('admin');

        $doctor=Role::findByName('doctor');

        $employee=Role::findByName('employee');
        
        $admin->syncPermissions($adminPermissions);

        $systemManager->syncPermissions($systemManagerPermissions);

        $employee->syncPermissions($employeePermissions);

        $doctor->syncPermissions($doctorPermissions);
    }
}
