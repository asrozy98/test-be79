<?php

namespace App\Http\Middleware;

use App\Http\Response\BaseResponses;
use Closure;
use Illuminate\Http\Request;

class RoleAuth
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
        if (auth()->user()->role == 'dosen') {
            return $next($request);
        } else {
            return BaseResponses::status(403, null, 'Role is not allowed');
        }
    }
}
