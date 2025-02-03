<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Clinic;
use Illuminate\Http\Request;

class ClinicController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clinics = Clinic::all();
        
        return successResponse(data:$clinics);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation=validator()->make($request->only(['name','status']),[
            'name'=>"required|string|unique:clinics,name",
            "status"=> "required|string|in:0,1",
        ]);

        $validation->validated();

        if($validation->fails()){
            return failResponse($validation->errors()->first());
        }

        $clinic= Clinic::create($request->only(['name','status']));

        return successResponse("تم اضافة عنصر بنجاح",$clinic);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $clinic = Clinic::find($id);

        if(!$clinic){
            return failResponse("لا يوجد عنصر بهذا id");
        }

        return successResponse(data:$clinic);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {   
        $validation=validator()->make($request->only(['name','status']),[
            'name'=>"required|string|unique:clinics,name",
            "status"=> "required|string|in:0,1",
        ]);

        $validation->validated();

        if($validation->fails()){
            return failResponse($validation->errors()->first());
        }

        $clinic= Clinic::find($id);

        if(!$clinic){
            return failResponse("لا يوجد عنصر بهذا id");
        }

        $clinic->update($request->only(['name','status']));

        return successResponse("تم تعديل عنصر بنجاح",$clinic);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clinic= Clinic::find($id);

        if(!$clinic){
            return failResponse("لا يوجد عنصر بهذا id");
        }

        $clinic->delete();

        return successResponse("تم حذف عنصر بنجاح");
    }
}
