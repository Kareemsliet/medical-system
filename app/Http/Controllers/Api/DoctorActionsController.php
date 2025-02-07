<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\DoctorActionsRequest;
use App\Http\Services\ImageService;
use Illuminate\Http\Request;

class DoctorActionsController extends Controller
{
    public $user;
    private $imageService;
    public function __construct(){
        $this->user=auth('sanctum')->user();
        $this->imageService=new ImageService();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $actions=$this->user->doctor->actions()->orderByDesc('created_at')->get();

        return successResponse(data: $actions);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DoctorActionsRequest $request)
    {
        $data=$request->validated();

        $this->user->doctor->actions()->create($data);

        return successResponse(message:"Doctor Actions Successfully Storage",data:$data);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $action=$this->user->doctor->actions()->with('doctor')->find($id);

        if(!$action){
            return failResponse(message:"Action not found");
        }

        return successResponse(data: $action);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DoctorActionsRequest $request, string $id)
    {
        $data=$request->validated();

        $action=$this->user->doctor->actions()->find($id);

        if(!$action){
            return failResponse(message:"Action not found");
        }

        $action->update($data);

        return successResponse(message:"Doctor Actions Successfully updated",data:$data);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $action=$this->user->doctor->actions()->find($id);

        if(!$action){
            return failResponse(message:"Action not found");
        }

        $action->delete();
        
        return successResponse(message:"Doctor Actions Delete Done");

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

        return successResponse(message:"Doctor Has Updated",data:$this->user->doctor);
    }

}
