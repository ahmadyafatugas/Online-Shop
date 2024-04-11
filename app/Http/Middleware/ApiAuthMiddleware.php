<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        $authenticate = true;
        if (!$token) {
            $authenticate = false;
        }
        if ($authenticate) {
            return $next($request);
        } else {
            if ($request->expectsJson()) {
                response()->json([
                    "errors" => [
                        "message" => [
                            "unauthorized"
                        ]
                    ]
                ])->setStatusCode(401);
            }
        }
    }
}
