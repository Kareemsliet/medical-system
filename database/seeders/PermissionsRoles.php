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
        $adminPermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic','all-clinics','show-clinic','insert-doctor','edit-doctor','delete-doctor','all-doctors','show-doctor','edit-user','insert-user','all-users','show-user','delete-user'])->get();

        $employeePermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic','insert-doctor','edit-doctor','delete-doctor','edit-user','insert-user','delete-user'])->get();
        
        $doctorPermissions=Permission::whereIn('name',["insert-doctor-action","edit-doctor-action","delete-doctor-action","show-doctor-action","all-doctor-actions","edit-profile"])->get();

        $admin=Role::findByName('admin');

        $doctor=Role::findByName('doctor');

        $employee=Role::findByName('employee');
        
        $admin->syncPermissions($adminPermissions);

        $employee->syncPermissions($employeePermissions);

        $doctor->syncPermissions($doctorPermissions);
    }
}
