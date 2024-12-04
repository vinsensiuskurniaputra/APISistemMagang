<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeLecturerController extends Controller
{

    public function index(Request $request)
    {
        $data = [
            "userId" => $request->user()->id,
            "name" => $request->user()->name,
            "students" => $request->user()->lecturer->students->map(function($student){
                return [
                    "id" => $student->id,
                    "name" => $student->user->name,
                    "username" => $student->user->username,
                    "photo_profile" => $student->user->photo_profile ? asset('storage/'.$student->user->photo_profile ) : null,
                    "class" => "{$student->studyProgram->study_program_initials} - {$student->class}",
                    "study_program" => $student->studyProgram->name,
                    "major" => $student->studyProgram->major,
                    "academic_year" => $student->academic_year,
                    "is_finished" => $student->is_finished == 1,
                    "activities" => [
                        "is_in_progress" => $student->guidances->contains('status', 'in-progress'),
                        "is_updated" => $student->guidances->contains('status', 'updated'),
                        "is_rejected" => $student->guidances->contains('status', 'rejected'),
                    ],
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
