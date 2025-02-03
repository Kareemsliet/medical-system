<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        $adminPermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic','all-clinics','show-clinic'])->get();

        $employeePermissions=Permission::whereIn('name',['insert-clinic','edit-clinic','delete-clinic'])->get();

        $admin=Role::findByName('admin');

        $employee=Role::findByName('employee');
        
        $admin->syncPermissions($adminPermissions);

        $employee->syncPermissions($employeePermissions);
    }
}
