<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Plan;

class SupscriptionsController extends Controller
{
    public function plans(){
        $plans=Plan::with('features')->orderBy('sort_order',"asc")->get();
        return successResponse(data:PlanResource::collection($plans));
    }
}
