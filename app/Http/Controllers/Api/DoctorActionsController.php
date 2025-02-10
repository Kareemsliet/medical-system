<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DoctorActionsRequest;
use App\Http\Resources\DoctorActionResource;
use App\Http\Resources\DoctorResource;
use App\Http\Services\ImageService;
use App\Models\Doctor;
use App\Models\DoctorAction;
use Illuminate\Http\Request;
use Pest\Plugins\Only;

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
    public function index($doctorId)
    {

        $doctor=Doctor::find($doctorId);

        if (!$doctor) {
            return failResponse(message: "الطبيب غير موجود");
        }

        $actions=$doctor->actions()->orderByDesc('created_at')->get();

        return successResponse(data:DoctorActionResource::collection($actions));
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

    public function updateProfile(Request $request){
        
        $validation=validator()->make($request->only(['image','signature']),[
            'image'=> $request->image ? "image|max:15000|mimes:png,jpg,jpeg" :"nullable",
            'signature'=> $request->image ? "image|max:15000|mimes:png,jpg,jpeg" :"nullable",            
        ]);

        if($validation->fails()){
            return failResponse(message:$validation->errors()->first());
        }

        $data=[];

        if ($request->file("image")) {
            if ($this->user->doctor->image) {
               $this->imageService->destroyImage($this->user->doctor->image, "doctors");
            }
            $image = $this->imageService->uploadImage($request->file("image"), "doctors");
            $data['image'] = $image;
        }

        if ($request->file("signature")) {
            if ($this->user->doctor->signature) {
                $this->imageService->destroyImage($this->user->doctor->signature, "doctors");
            }
            $signature = $this->imageService->uploadImage($request->file("signature"), "doctors");
            $data["signature"] = $signature;
        }

        $this->user->doctor->update($data);

        return successResponse(message:"تم تحديث الطبيب بنجاح",data:$this->user->doctor);
    }

}
