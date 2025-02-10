<?php

use App\Models\Company;
use App\Models\Setting;

function failResponse($message =null, $data = null)
{
    $response = [
        'status' => false,
        "message" => $message,
        "data" => $data,
    ];
    return response()->json($response,200);
}

function successResponse($message = null, $data = null){
    $response = [
        'status' => true,
        "message" => $message,
        "data" => $data,
    ];
    return response()->json($response,200);
}

function unAuthorize($message="ليس لديك صلاحية"){
    $response = [
        'status' => false,
        "message" => $message,
    ];
    return response()->json($response,403);
}

function sections(){
      $sections=[];

        $sections['companies']['count']=Company::count('id');
        $sections['companies']['name']="الشركات";
        $sections['companies']['icon']="building";
        $sections['companies']['pages']['add']['route']="companies.create";
        $sections['companies']['pages']['add']['permission']="اضافة مدينة";
        $sections['companies']['pages']['index']['route']="companies.index";
        $sections['companies']['pages']['index']['permission']="المدن";

        return $sections;
}

function setting(){
    $setting=Setting::first();
    return $setting;
}