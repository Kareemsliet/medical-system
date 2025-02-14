<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HasVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()->hasVerifiedEmail()) {
            return failResponse("عذراً، لم نتمكن من التحقق من بريدك الإلكتروني. يرجى المحاولة مرة أخرى.");
        }
        return $next($request);
    }
}
