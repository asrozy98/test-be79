<?php

namespace App\Http\Middleware;

use App\Http\Response\BaseResponses;
use Closure;
use Exception;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return BaseResponses::status(401, null, 'Token is Invalid');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return BaseResponses::status(400, null, 'Token is Expired');
            } else {
                return BaseResponses::status(401, null, 'Authorization Token not found');
            }
        }
        return $next($request);
    }
}
