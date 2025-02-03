<?php

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