<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasSupscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentCompany=$request->user()->company;
        if(!$currentCompany->planSubscription('main')->active()){
            if($currentCompany->planSubscription('main')->ended()){
                return failResponse("انتهت الباقة الرئيسية الرجاء تجديد الباقة");                
            }
            return failResponse("الرجاء الاشتراك في احدى الباقات للمتابعة");
        }
        return $next($request);
    }
}
