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
            "latest_guidances" => $request->user()->student->guidances()->latest('updated_at')->take(2)->get()->map(function ($guidance) {
                return [
                    'id' => $guidance->id,
                    'title' => $guidance->title,
                    'activity' => $guidance->activity,
                    'date' => $guidance->date,
                    'lecturer_note' => $guidance->lecturer_note,
                    'status' => $guidance->status,
                    'name_file' => $guidance->name_file != null ? asset('storage/' . $guidance->name_file) : null,
                ];
            }),
            "latest_log_books" => $request->user()->student->logBooks()->latest('updated_at')->take(2)->get()
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }
}
