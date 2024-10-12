<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'code' => '200',
            'status' => 'success',
            'message' => 'Logged out successfully.'
        ], 200);
    }

    public function resetPassword(Request $request){
        $validator = Validator::make( $request->all(),[
            'password' => ['required'],
            'new_password' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $credentials->errors()
            ],400);
        }

        $user = $request->user();

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "code" => "401",
                "status" => "UNAUTHORIZED",
                "errors" => [
                    "message" => "Password is incorrect."
                ]
            ], 401);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json([
            'code' => '200',
            'status' => 'success',
            'message' => 'Password reset successfully.'
        ], 200);
    }
}
