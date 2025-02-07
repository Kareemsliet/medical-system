<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UsersRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{

    public $company;
    public function __construct(){
        $this->company=auth('sanctum')->user()->company;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users=User::all();

        return successResponse(data:UserResource::collection($users));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request)
    {
        $request->validated();

        $role=Role::find($request->input("role_id"));

        $user=$this->company->users()->create($request->only(['email',"password"]));

        $user->syncRoles([$role]);

        return successResponse("Successfully Storage Done!",data:new UserResource($user));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user=User::find($id);

        if(!$user){
            return failResponse("Not Found Data");
        }

        return successResponse(data:new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UsersRequest $request, string $id)
    {
        $request->validated();

        $role=Role::find($request->input("role_id"));

        $user=User::find($id);

        if(!$user){
            return failResponse("Not Found Data");
        }

        $user->update($request->only(["email","password"]));
        
        $user->syncRoles([$role]);

        return successResponse("Successfully Updated",data:new UserResource($user));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user=User::find($id);

        if(!$user){
            return failResponse("Not Found Data");
        }

        if($user->doctor){
            $user->doctor->delete();
        }
        
        $user->delete();

        return successResponse("Done Successfully deleted");
    }
}
