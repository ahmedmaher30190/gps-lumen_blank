<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class ApiAuthenticate
{

    protected $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        header('Access-Control-Allow-Origin: *');
        if(!empty($request->header('x-api-key'))){
            $apiKey = $request->header('x-api-key');
            if($apiKey !== env('JWT_SECRET')) {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid x-api-key',
                    'error_code' => 401,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized api',
                'error_code' => 401,
            ], 200);
        }
        return $next($request);
    }
}
