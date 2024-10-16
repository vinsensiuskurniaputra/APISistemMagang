<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeLecturerController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            "name" => $request->user()->name,
            "students" => $request->user()->lecturer->students->map(function($student){
                return [
                    "id" => $student->id,
                    "name" => $student->user->name,
                    "username" => $student->user->username,
                    "class" => $student->studyProgram->study_program_initials,
                    "study_program" => $student->studyProgram->name,
                    "major" => $student->studyProgram->major,
                    "academic_year" => $student->academic_year,
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
