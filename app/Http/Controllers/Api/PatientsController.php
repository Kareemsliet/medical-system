<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PatientPasswordRequest;
use App\Http\Requests\Api\PatientRequest;
use App\Http\Resources\PatientResource;
use App\Http\Services\ImageService;
use App\Http\Services\UserService;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public $imageService;

     public function __construct(){
        $this->imageService = new ImageService();
     }

    public function index()
    {
        $patients=Patient::all();

        return successResponse(data:PatientResource::collection($patients));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PatientRequest $request)
    {
      $request->validated();
      
      $data=$request->only(['name',"first_phone","second_phone","another_name","description","personal_id","status","grander"]);
      
      $user=(new UserService())->store($request->only(['email','password']),"patient");

      $personalImage=$this->imageService->uploadImage($request->file("personal_image"),"patients");

      $data['personal_image']=$personalImage;

      $patient=$user->patient()->create($data);

      return successResponse(data: new PatientResource($patient));
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient=Patient::find($id);

        if(!$patient){
            return failResponse("Dont found patient");
        }

        return successResponse(data: new PatientResource($patient));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PatientRequest $request, string $id)
    {
      $request->validated();

      $data=$request->only(['name',"first_phone","second_phone","another_name","description","personal_id","status","grander"]);

      $patient=Patient::find($id);

      if(!$patient){
          return failResponse("Dont found patient");
      }

      $this->imageService->destroyImage($patient->personal_image,"patients");

      $personalImage=$this->imageService->uploadImage($request->file("personal_image"),"patients");

      $data['personal_image']=$personalImage;

      $patient->user->update($request->only(['email','password']));

      $patient->update($data);
      
      return successResponse(data: new PatientResource($patient));
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient=Patient::find($id);

        if(!$patient){
            return failResponse("Dont found patient");
        }

        $patient->user()->delete();

        $patient->delete();

        return successResponse("Successfully Deleted Done");
    }

    public function updatePassword(PatientPasswordRequest $request){

        $request->validated();

        $user=User::where("email",$request->email)->first();

        if($user){
            if($user->isRole("patient") && $user->hasRole("patient")){
                $user->update(['password'=>$request->password]);
                return successResponse("Succefully Password updated");
            }else{
                return unAuthorize();
            }
        }else{
            return failResponse("not found email");
        }
    }

}
