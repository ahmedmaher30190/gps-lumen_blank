<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServersToken;
use Illuminate\Support\Facades\Validator;


class ServersTokensController extends Controller{

    public function createToken(Request $request){

        $validator = Validator::make($request->all(), [
            'server_name' => 'required',
            'server_ip' => 'required|unique:servers_tokens'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'error_code' => 422,
                'message' => $validator->errors()
            ], 200);
        }

        $token = new ServersToken;
        $token->server_name = $request->server_name;
        $token->server_ip = $request->server_ip;
        $token->server_token = make_token(40);
        $token->save();
        $token->server_token = $token->server_token.make_token(20);
        $hashedData =  base64_encode($token);

        return response()->json([
            'status' => true,
            'data' => $hashedData,
        ], 200);
    }

}
