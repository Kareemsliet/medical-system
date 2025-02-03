<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClinicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/auth',AuthController::class);

Route::apiResource('/clinics',ClinicController::class)
->middleware(['auth:sanctum','autoPermission']);