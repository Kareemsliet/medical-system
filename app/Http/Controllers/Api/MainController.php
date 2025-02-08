<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use Laravelcm\Subscriptions\Models\Plan;
use Spatie\Permission\Models\Role;

class MainController extends Controller
{
    public function plans(){
        $plans=Plan::with('features')->orderBy('sort_order',"asc")->get();
        return successResponse(data:PlanResource::collection($plans));
    }

    public function roles(){
        $roles=Role::whereIn('name',['doctor','admin','employee','patient'])->get();
        return successResponse(data:$roles);
    }

}
