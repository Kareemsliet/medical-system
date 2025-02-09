<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravelcm\Subscriptions\Models\Plan;
use Symfony\Component\HttpFoundation\Response;


class CompanyTrackRequest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,string $featureName): Response
    {
        $mainSupscription=$request->user()->company->planSubscription('main');

        $featureSlug="max-".$featureName;

        if(!$mainSupscription->getFeatureRemainings($featureSlug) > 0) {
            return unAuthorize("you have a limit request of feature");
        }

        $mainSupscription->recordFeatureUsage($featureSlug);

        return $next($request);
    }

}
