<?php

namespace App\Http\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;


class UserService {
    
    protected $company;
    public function __construct(){
        $this->company=auth('sanctum')->user()->company;
    }
    
    public function store($data,$roleName){
        
        $user=$this->company->users()->create($data);

        $role=Role::where("name",$roleName)->first();

        $user->syncRoles([$role]);

        return $user;
    }

    public function update($user_id,$data){
        $user_id->update($data);
    }

}