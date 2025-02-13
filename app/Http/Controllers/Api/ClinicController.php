<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ClinicRequest;
use App\Http\Resources\ClinicResource;
use App\Models\Clinic;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public $company;
    public function __construct(){
        $this->company=auth('sanctum')->user()->company;
    }
    public function index()
    {
        $clinics = Clinic::byCompany($this->company->id)->orderByDesc("created_at")->get();

        return successResponse(data:ClinicResource::collection($clinics));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ClinicRequest $request)
    {
        $data=$request->validated();

        $clinic=$this->company->clinics()->create($data);

        return successResponse("تم اضافة عنصر بنجاح",new ClinicResource($clinic));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clinic = Clinic::find($id);

        if(!$clinic){
            return failResponse(message: "العياده غير موجودة");
        }

        return successResponse(data:new ClinicResource($clinic));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ClinicRequest $request, string $id)
    {   
        $data=$request->validated();

        $clinic= Clinic::find($id);

        if(!$clinic){
            return failResponse("العياده غير موجودة");
        }

       $clinic->update($data);

        return successResponse("تم تعديل عنصر بنجاح",new ClinicResource($clinic));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clinic= Clinic::find($id);

        if(!$clinic){
            return failResponse("العياده غير موجودة");
        }

        $clinic->delete();

        return successResponse("تم حذف عنصر بنجاح");
    }
}
