<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotPatient
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // If the user is not authenticated as patient
        if($request->routeIs('patient.*')) {
            if(!Auth::guard('patient')->check()) {
                return redirect()->route('patient.login');
            }                
        }
        return $next($request);
    }
}
