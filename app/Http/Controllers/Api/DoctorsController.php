<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DoctorRequest;
use App\Http\Services\ImageService;
use App\Models\Doctor;
use App\Models\User;

class DoctorsController extends Controller
{
    private $imageService;
    private $company;
    public function __construct(){
        $this->imageService = new ImageService();   
        
        $this->company=auth('sanctum')->user()->company;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::all();

        return successResponse(data: $doctors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        $request->validated();

        $data = $request->only(['name','first_phone','second_phone', 'image', 'commission', 'status', 'personal_id','user_id']);

        if($request->file("image")) {
            $image = $this->imageService->uploadImage($request->file('image'),"doctors");
            $data['image'] = $image;
        }

        if($request->file("signature")) {
            $signature = $this->imageService->uploadImage($request->file('signature'), "doctors");
            $data['signature'] = $signature;
        }

        $doctor = $this->company->doctors()->create($data);

        return successResponse(data: $doctor);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return failResponse(message: "Doctor not found");
        }

        return successResponse(data: $doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, string $id)
    {
        $request->validated();

        $doctor = Doctor::find($id);

        if (!$doctor) {
            return failResponse(message: "Doctor not found");
        }

        $data = $request->only(['name','first_phone',"user_id",'second_phone', 'image', 'commission', 'status', 'personal_id']);

        if ($request->file("image")) {
            if ($doctor->image) {
               $this->imageService->destroyImage($doctor->image, "doctors");
            }
            $image = $this->imageService->uploadImage($request->file("image"), "doctors");
            $data['image'] = $image;
        }

        if ($request->file("signature")) {
            if ($doctor->signature) {
                $this->imageService->destroyImage($doctor->signature, "doctors");
            }
            $signature = $this->imageService->uploadImage($request->file("signature"), "doctors");
            $data["signature"] = $signature;
        }

        $doctor->update($data);

        return successResponse(message: "Doctor updated successfully", data: $doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);

        if(!$doctor){
            return failResponse(message:"Doctor not found");
        }

        if($doctor->image){
            $this->imageService->destroyImage($doctor->image, "doctors");
        }

        if($doctor->signature){
            $this->imageService->destroyImage($doctor->signature, "doctors");
        }

        $doctor->delete();

        return successResponse(message:"Doctor deleted successfully");
    }
}
