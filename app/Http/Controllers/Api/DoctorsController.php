<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DoctorRequest;
use App\Http\Resources\Collection\DoctorsCollection;
use App\Http\Resources\DoctorResource;
use App\Http\Services\ImageService;
use App\Http\Services\UserService;
use App\Models\Clinic;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorsController extends Controller
{
    private $imageService;
    public function __construct(){
        $this->imageService = new ImageService();   
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit=$request->query('limit',20);

        $user=auth('sanctum')->user();

        $company=$user->company;

        $doctors = Doctor::byCompany($company->id)->orderByDesc("created_at")->paginate($limit);

        $doctors->withQueryString();

        return successResponse(data:new DoctorsCollection($doctors));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorRequest $request)
    {
        $request->validated();

        $data = $request->only(['name','first_phone','second_phone','commission', 'status', 'personal_id',"register_id","gender"]);

        $user=(new UserService())->store($request->only(['email','password']),"doctor");

        if($request->file("image")) {
            $image = $this->imageService->uploadImage($request->file('image'),"doctors");
            $data['image'] = $image;
        }

        if($request->file("signature")) {
            $signature = $this->imageService->uploadImage($request->file('signature'), "doctors");
            $data['signature'] = $signature;
        }

        $doctor = $user->doctor()->create($data);

        $clinics=Clinic::findMany($request->clinics);

        $doctor->clinics()->attach($clinics);

        return successResponse(message:"تم اضافة الطبيب  بنجاح",data:new DoctorResource($doctor));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return failResponse(message: "الطبيب غير موجود");
        }

        return successResponse(data:new DoctorResource($doctor));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorRequest $request, string $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return failResponse(message: "الطبيب غير موجود");
        }

        $request->validated();

        $data = $request->only(['name','first_phone','second_phone','commission', 'status', 'personal_id',"register_id","gender"]);

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

        if($request->input('email')){
            $doctor->user->update($request->only(['email']));
        }

        if($request->input("password")){
            $doctor->user->update($request->only(['password']));
        }

        $clinics=Clinic::findMany($request->clinics);

        $doctor->clinics()->sync($clinics);

        return successResponse(message: "تم تعديل الطبيب بنجاح", data:new DoctorResource(($doctor)));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $doctor = Doctor::find($id);

        if(!$doctor){
            return failResponse(message:"الطبيب غير موجود");
        }

        $doctor->user->delete();

        $doctor->delete();

        return successResponse(message:"تم حذف الطبيب بنجاح");
    }
}
