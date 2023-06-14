<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TeachersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user()->usertype;
        $allowedUserTypes = ['admin', 'proprietor', 'director', 'accountant','teacher'];
        
        if (in_array($user, $allowedUserTypes)) {
            return $next($request);
        } else {
            auth()->logout();
            return redirect()->route('login');
        }
    }
}
