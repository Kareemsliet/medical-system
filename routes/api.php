<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\DoctorActionsController;
use App\Http\Controllers\Api\DoctorsController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;


Route::post('/auth',[AuthController::class,'login']);

Route::group(['middleware'=>['auth:sanctum',"autoPermission"]],function(){
    Route::apiResource('/users',UsersController::class)->only(['index']);
    Route::post('/logout',[AuthController::class,"logout"])->name('logout');
    Route::apiResource('/clinics',ClinicController::class);
    Route::apiResource('/doctors',DoctorsController::class);
    Route::group(['middleware'=>"hasRole:doctor"],function(){
        Route::apiResource('/actions',DoctorActionsController::class);
        Route::post("/profile/update",[DoctorActionsController::class,"updateProfile"])->name("profile.update");
    });
});