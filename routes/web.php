<?php

use App\Http\Controllers\Panel\AuthController;
use App\Http\Controllers\Panel\CompaniesController;
use App\Http\Controllers\Panel\MainController;
use App\Http\Controllers\Panel\SettingController;
use Illuminate\Support\Facades\Route;

Route::get("/",function(){
    if(auth('manager')->check()){
        return redirect()->route("panel.index");
    }else{
        return redirect()->route("panel.login");
    }
});

Route::group(["prefix"=> "admin-panel"], function(){
    Route::group(["middleware"=>"guest:manager"], function(){
       Route::get("/login",[AuthController::class,"showLoginForm"])->name("panel.login");
       Route::post("/login",[AuthController::class,"login"])->name("panel.loginForm");
    });
   
    Route::get("/password/forget",[AuthController::class,"showForgetPasswordForm"])->name("panel.password.forget");
    Route::post("/password/update",[AuthController::class,"updatePassword"])->name("panel.password.update");
   
    Route::group(['middleware'=>"auth:manager"], function () {
        Route::get("/", [MainController::class,"index"])->name("panel.index");
        Route::post("/logout",[AuthController::class,"logout"])->name("panel.logout");
        Route::resource("/companies",CompaniesController::class)->except(['update','destroy','edit']);
        Route::resource("/setting",SettingController::class)->except(["create","edit",'show']);
        Route::post('supscriptions/{company}/cancel',[CompaniesController::class,"cancelSupscription"])->name('supscriptions.cancel');
        Route::post('supscriptions/{company}/update',[CompaniesController::class,"updateSupscription"])->name('supscriptions.update');
    });
});