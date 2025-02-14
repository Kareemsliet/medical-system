<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClinicController;
use App\Http\Controllers\Api\DoctorActionsController;
use App\Http\Controllers\Api\DoctorsController;
use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\PatientsController;
use Illuminate\Support\Facades\Route;

Route::post('/auth', [AuthController::class, 'login']);

Route::post("/check-auth", [AuthController::class, "check"]);

Route::post("/password/confirmation-notification",[AuthController::class,"sendResetPasswordCode"])->middleware("throttleApi:2,1");

Route::post("password/reset",[AuthController::class,"resetPassword"]);

Route::get('/plans', [MainController::class, "plans"])->name('plans');

Route::get('/roles', [MainController::class, "roles"])->name("roles");

Route::group(['middleware' => ['auth:sanctum', "autoPermission"]], function () {
    Route::post("/email/verification-notification", [AuthController::class, "sendEmailVerification"])->middleware("throttleApi:1,1");
    Route::post("/email/verify",[AuthController::class,"verifyEmail"]);
    Route::group(["middleware" => "hasVerified"], function () {
        Route::post('/logout', [AuthController::class, "logout"])->name('logout');
        Route::get("/me", [MainController::class, "getProfile"]);
        Route::post("/me", [MainController::class, "updateProfile"]);
        Route::apiResource('/clinics', ClinicController::class);
        Route::apiResource('/doctors', DoctorsController::class);
        Route::apiResource("/employees", EmployeesController::class);
        Route::apiResource("/patients", PatientsController::class);
        Route::apiResource('/actions', DoctorActionsController::class)->except(['index']);
        Route::get("/{doctor_id}/actions", [DoctorActionsController::class, "index"])->name("actions.index");
        Route::post("/password/update",[AuthController::class,"updatePassword"]);
    });
});
