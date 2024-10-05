<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function authenticate(Request $request)
    {
        $credentials = Validator::make( $request->all(),[
            'username' => ['required'],
            'password' => ['required'],
        ]);
        if($credentials->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $credentials->errors()
            ],400);
        }
        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            $auth = Auth::user();
            $user = [
                "token" => $auth->createToken('auth_token')->plainTextToken,
                "name" => $auth->name,
                "role" => $auth->role,
            ];
            return response()->json([
                "code" => "200",
                "status" => "OK",
                "data" => $user
            ],200);
        }
        return response()->json([
            "code" => "401",
            "status" => "UNAUTHORIZED",
            "errors" => [
                "message" => "Username or Password Wrong"
            ]
        ],401);
    }
}
