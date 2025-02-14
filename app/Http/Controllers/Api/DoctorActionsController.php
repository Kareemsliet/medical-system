<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DoctorActionsRequest;
use App\Http\Resources\Collection\DoctorActionsCollection;
use App\Http\Resources\DoctorActionResource;
use App\Http\Services\ImageService;
use App\Models\Doctor;
use App\Models\DoctorAction;
use Illuminate\Http\Request;

class DoctorActionsController extends Controller
{
    public $user;
    private $imageService;
    public function __construct(){
        $this->user = auth()->user();
        $this->imageService=new ImageService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$doctorId)
    {
        $limit=$request->query('limit',20);

        $doctor=Doctor::find($doctorId);

        if (!$doctor) {
            return failResponse(message: "الطبيب غير موجود");
        }

        $actions=$doctor->actions()->orderByDesc('created_at')->paginate($limit);

        $actions->withQueryString();

        return successResponse(data:new DoctorActionsCollection($actions));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorActionsRequest $request)
    {
        $request->validated();

        $data=$request->only(['name','price']);

        $doctor =Doctor::find($request->input("doctor_id"));

        $action=$doctor->actions()->create($data);

        return successResponse(message:"العملية تم اضافتها بنجاح",data:new DoctorActionResource($action));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $action=DoctorAction::find( $id);

        if(!$action){
            return failResponse(message:"العملية غير موجودة");
        }

        return successResponse(data:new DoctorActionResource($action));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorActionsRequest $request,string $id)
    {
        $request->validated();

        $data=$request->only(["name","price","doctor_id"]);

        $action=DoctorAction::find($id);
        
        if(!$action){
            return failResponse(message:"العملية غير موجودة");
        }

        $action->update($data);

        return successResponse("العملية تم تعديلها بنجاح",new DoctorActionResource($action));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $action=DoctorAction::find($id);
        
        if(!$action){
            return failResponse(message:"العملية غير موجودة");
        }

        $action->delete();
        
        return successResponse(message:"العملية تم حذفها بنجاح");

    }
}
