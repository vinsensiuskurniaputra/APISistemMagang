<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeStudentController extends Controller
{
    public function index(Request $request)
    {

        $data = [
            "name" => $request->user()->name,
            "seminar" => null,
            "latest_guidances" => $request->user()->student->guidances()->latest()->take(2)->get(),
            "latest_log_books" => $request->user()->student->logBooks()->latest()->take(2)->get()
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }
}
