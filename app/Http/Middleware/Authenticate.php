<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard('user')->guest()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized user.',
                'error_code' => 401,
            ], 200);
        }
        return $next($request);
    }
}
