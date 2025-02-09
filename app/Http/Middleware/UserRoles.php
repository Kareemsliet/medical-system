<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class UserRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $route_name=$request->route()->getName();
        $permission=Permission::whereRaw("FIND_IN_SET('$route_name',routes)")->first();
        if($permission){
            if(!$request->user()->hasPermissionTo($permission)){
                return unAuthorize();
            }
        }
        return $next($request);
    }
}
