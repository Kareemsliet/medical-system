<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\EmployeeRequest;
use App\Http\Resources\Collection\EmployeesCollection;
use App\Http\Resources\EmployeeResource;
use App\Http\Services\ImageService;
use App\Http\Services\UserService;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeesController extends Controller
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

        $employees = Employee::byCompany($company->id)->orderByDesc("created_at")->paginate($limit)->withQueryString();

        return successResponse(data:new EmployeesCollection($employees));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $request->validated();

        $data = $request->only(['name','first_phone','second_phone','status',"gender",'personal_id','job','salary']);

        $user=(new UserService())->store($request->only(['email','password']),$request->role);

        if($request->file("image")) {
            $image = $this->imageService->uploadImage($request->file('image'),"employees");
            $data['image'] = $image;
        }

        if($request->file("personal_image")) {
            $personal_image = $this->imageService->uploadImage($request->file('personal_image'), "employees");
            $data['personal_image'] = $personal_image;
        }

        $employee = $user->employee()->create($data);

        return successResponse(message:"تم تحديث الموظف بنجاح",data:new EmployeeResource($employee));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return failResponse(message: "الموظف غير موجود");
        }

        return successResponse(data:new EmployeeResource($employee));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return failResponse(message: "الموظف غير موجود");
        }
        
        $request->validated();

        $data = $request->only(['name','first_phone','second_phone','status',"gender",'personal_id','job','salary']);

        if ($request->file("image")) {
            if ($employee->image) {
               $this->imageService->destroyImage($employee->image, "employees");
            }
            $image = $this->imageService->uploadImage($request->file("image"), "employees");
            $data['image'] = $image;
        }

        if ($request->file("personal_image")) {
            if ($employee->personal_image) {
                $this->imageService->destroyImage($employee->personal_image, "employees");
            }
            $personal_image = $this->imageService->uploadImage($request->file("personal_image"), "employees");
            $data["personal_image"] = $personal_image;
        }

        if($request->input('email')){
            $employee->user->update($request->only(['email']));
        }

        if($request->input("password")){
            $employee->user->update($request->only(['password']));
        }

        $employee->update($data);

        return successResponse(message: "تم تعديل الموظف بنجاح", data:new EmployeeResource(($employee)));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        if(!$employee){
            return failResponse(message:"الموظف غير موجود");
        }

        $employee->user()->delete();

        $employee->delete();

        return successResponse(message:"تم حذف الموظف بنجاح");
    }
}
