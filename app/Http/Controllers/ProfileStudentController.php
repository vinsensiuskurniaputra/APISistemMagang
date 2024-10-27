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
            "photo_profile" => $request->user()->photo_profile ? $data["photo_profile"] = asset('storage/' . $request->user()->photo_profile) : null,
            "internships" => $request->user()->student->internships->map(function($internship){
                return [
                    "name" => $internship->industry->name,
                    "address" => $internship->industry->address,
                    "city" => $internship->industry->city,
                    "start_date" => $internship->start_date,
                    "end_date" => $internship->end_date,
                ];
            }),
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }
}
