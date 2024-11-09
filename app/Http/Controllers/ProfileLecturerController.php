<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileLecturerController extends Controller
{
    public function index(Request $request){
        $data = [
            "name" => $request->user()->name,
            "username" => $request->user()->username,
            "email" => $request->user()->email,
            "photo_profile" => $request->user()->photo_profile ? asset('storage/' . $request->user()->photo_profile) : null,
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }
}
