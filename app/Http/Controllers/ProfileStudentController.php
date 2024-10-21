<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfileStudentController extends Controller
{
    public function index(Request $request)
    {

        $data = [
            "name" => $request->user()->name,
            "username" => $request->user()->username,
            "email" => $request->user()->email,
            "photo_profile" => $request->user()->photo_profile,
            "internship" => $request->user()->student->internship,
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }
}
