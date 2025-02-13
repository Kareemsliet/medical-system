<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Services\ImageService;
use App\Http\Services\UserService;
use App\Models\Patient;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public $imageService;

    public function __construct()
    {
        $this->imageService = new ImageService();
    }

    public function index()
    {
        $user = auth('sanctum')->user();

        $company = $user->company;

        $patients = Patient::byCompany($company->id)->get();

        return successResponse(data: PatientResource::collection($patients));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
        $request->validated();

        $data = $request->only(['name', "first_phone", "second_phone", "another_name", "description", "personal_id", "status", "gender"]);

        $user = (new UserService())->store($request->only(['email', 'password']), "patient");

        if ($request->file("personal_image")) {
            
            $personalImage = $this->imageService->uploadImage($request->file("personal_image"), "patients");

            $data['personal_image'] = $personalImage;
        }

        $patient = $user->patient()->create($data);

        return successResponse(message: "تم تحديث المريض بنجاح", data: new PatientResource($patient));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return failResponse("المريض غير موجود");
        }

        return successResponse(data: new PatientResource($patient));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, string $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return failResponse("لا يوجد مريض بهذا الرقم");
        }

        $request->validated();

        $data = $request->only(['name', "first_phone", "second_phone", "another_name", "description", "personal_id", "status", "gender"]);

        if ($request->file("personal_image")) {
            if ($patient->personal_image) {
                (new ImageService())->destroyImage($patient->personal_image, "patients");
            }
            $personal_image = (new ImageService())->uploadImage($request->file("personal_image"), "patients");
            $data["personal_image"] = $personal_image;
        }

        if ($request->input('email')) {
            $patient->user->update($request->only(['email']));
        }

        if ($request->input("password")) {
            $patient->user->update($request->only(['password']));
        }

        $patient->update($data);

        return successResponse(message: "تم تحديث المريض بنجاح", data: new PatientResource($patient));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = Patient::find($id);

        if (!$patient) {
            return failResponse("المريض غير موجود");
        }

        $patient->user()->delete();

        $patient->delete();

        return successResponse("تم حذف المريض بنجاح");
    }
}
