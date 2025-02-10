<?php

use App\Http\Middleware\CompanyTrackRequest;
use App\Http\Middleware\HasRole;
use App\Http\Middleware\HasSupscribed;
use App\Http\Middleware\UserRoles;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->api(prepend: [
            \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->statefulApi();

        $middleware->alias([
           'autoPermission'=>UserRoles::class,
           'hasRole'=>HasRole::class,
           "hasSubscriped"=>HasSupscribed::class,
           "track.request"=> CompanyTrackRequest::class,
        ]);

        $middleware->redirectUsersTo(function(){
            if(auth('manager')->check()){
                return route("panel.index");
            }else{
                return route("panel.index");
            }
        });

        $middleware->redirectGuestsTo(function(){
            if(auth('manager')->guest()){
                return route("panel.login");
            }else{
                return route("panel.login");
            }
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
