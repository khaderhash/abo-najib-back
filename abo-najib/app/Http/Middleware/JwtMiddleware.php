<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken ()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof TokenInvalidException) {
                return Response()->json(['status'=>'Token is Invalid']);
        }
        else if ($e instanceof TokenExpiredException) {
            return  Response()->json(['status'=>'Token is Expired']);
        }
        else {
            return  Response()->json(['status'=>'Authorization token not found']);
            }
        }
            return $next($request);
    }
}
