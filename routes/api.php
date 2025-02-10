<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\CompaniesController;
use App\Http\Controllers\Api\DoctorActionsController;
use App\Http\Controllers\Api\DoctorsController;
use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\PatientsController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

Route::post('/auth',[AuthController::class,'login']);

Route::post("/check-auth",[AuthController::class,"check"]);

Route::get('/plans',[MainController::class,"plans"])->name('plans');

Route::get('/roles',[MainController::class,"roles"])->name("roles");

Route::group(['middleware'=>['auth:sanctum',"autoPermission"]],function(){
    Route::post('/logout',[AuthController::class,"logout"])->name('logout');
    Route::apiResource('/clinics',ClinicController::class);
    Route::apiResource('/doctors',DoctorsController::class);
    Route::apiResource("/employees",EmployeesController::class);
    Route::apiResource("/patients",PatientsController::class);
    Route::apiResource('/actions',DoctorActionsController::class)->except(['index']);
    Route::get("/{doctor_id}/actions",[DoctorActionsController::class,"index"])->name("action.index");
    Route::group(['middleware'=>"hasRole:doctor"],function(){
        Route::post("/profile/update",[DoctorActionsController::class,"updateProfile"])->name("profile.update");
    });
});

Route::post('/password-update',[PatientsController::class,"updatePassword"])->name("patient.password.update");
