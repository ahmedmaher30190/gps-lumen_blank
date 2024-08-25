<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\ServersToken;


class TokenAuthenticate
{

    protected $auth;
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        header('Access-Control-Allow-Origin: *');
        if(!empty($request->header('token'))){
            $token = json_decode(base64_decode($request->header('token')));
            $server_token = (string)substr($token->server_token, 0, 40);
            $server = ServersToken::where('server_token', $server_token)->get();
            if(!$server) {
                return response()->json([
                    'status' => true,
                    'message' => 'Invalid token',
                    'error_code' => 401,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized user',
                'error_code' => 401,
            ], 200);
        }
        return $next($request);
    }
}
