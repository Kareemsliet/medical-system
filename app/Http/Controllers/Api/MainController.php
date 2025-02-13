<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProfileRequest;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\EmployeeResource;
use App\Http\Resources\PatientResource;
use App\Http\Resources\PlanResource;
use App\Http\Services\ImageService;
use Illuminate\Http\Request;
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

    public function getProfile(Request $request){
        
        $user=$request->user();

        if($user->isRole("doctor")){
            return successResponse(data:new DoctorResource($user->doctor));
        }

        if($user->isRole("employee")){
            return successResponse(data:new EmployeeResource($user->employee));
        }

        if($user->isRole("patient")){
            return successResponse(data:new PatientResource($user->patient));
        }

        return failResponse(message:"User not found");
    }

    public function updateProfile(ProfileRequest $request){
        
        $request->validated();

        $user=$request->user();

        if($user->isRole("doctor")){

            $data=[];

            if ($request->file("image")) {
                if ($user->doctor->image) {
                   (new ImageService())->destroyImage($user->doctor->image, "doctors");
                }
                $image = (new ImageService())->uploadImage($request->file("image"), "doctors");
                $data['image'] = $image;
            }
    
            if ($request->file("signature")) {
                if ($user->doctor->signature) {
                    (new ImageService())->destroyImage($user->doctor->signature, "doctors");
                }
                $signature = (new ImageService())->uploadImage($request->file("signature"), "doctors");
                $data["signature"] = $signature;
            }

            $user->doctor()->update($data);

            return successResponse("تم تحديث البيات بنجاح");
        }

        if($user->isRole("patient")){
            
            $data=$request->only(["another_name","first_phone","second_phone","email"]);

            if(!$user->patient->status){
                if ($request->file("personal_image")) {
                    if ($user->patient->personal_image) {
                        (new ImageService())->destroyImage($user->patient->personal_image, "patients");
                    }
                    $personal_image = (new ImageService())->uploadImage($request->file("personal_image"), "patients");
                    $data["personal_image"] = $personal_image;
                }
            }

            $user->patient()->update($data);

            return successResponse("تم تحديث البيات بنجاح");
        }

        return failResponse(" المستخدم يجب ان يكون مريض او دكتور لحين نزول تحديث اخر");
    }

}
