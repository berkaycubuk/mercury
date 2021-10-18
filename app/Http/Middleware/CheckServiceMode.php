<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckServiceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (get_settings('site')->service_mode) {
            if (!empty(auth()->user()) && auth()->user()->role == 'admin') {
                return $next($request);
            }
            return redirect()->route('service-mode');
        }

        return $next($request);
    }
}
