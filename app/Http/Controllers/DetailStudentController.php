<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Student;
use App\Models\Guidance;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class DetailStudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Student $student)
    {
        $dataStudent = [
            "name" => $student->user->name,
            "username" => $student->user->username,
            "email" => $student->user->email,
            "major" => $student->studyProgram->major,
            "class" => "{$student->studyProgram->study_program_initials} - {$student->class}",
            "is_finished" => $student->is_finished,
        ];

        $data = [
            "student" => $dataStudent,
            "internships" => $student->internships->map(function($internship){
                return [
                    "name" => $internship->industry->name,
                    "address" => $internship->industry->address,
                    "city" => $internship->industry->city,
                    "start_date" => $internship->start_date,
                    "end_date" => $internship->end_date,
                ];
            }),
            "assessments" => $student->assessments,
            "guidances" => $student->guidances()->latest()->get(),
            "log_book" => $student->logBooks()->latest()->get(),
        ];


        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Guidance $guidance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guidance $guidance)
    {
        $statuses = Guidance::STATUSES;
        $validator = Validator::make( $request->all(),[
            'status' => ['required', Rule::in($statuses)],
            'lecturer_note' => ['nullable'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $data = [
            'status' => $request->status,
            'updated_at' => now(),
        ];

        if($request->lecturer_note != null){
            $data['lecturer_note'] = $request->lecturer_note;
        }

        $guidance->update($data);

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Success"
            ]
        ],200);

    }

    public function updateFinishedStudent(Request $request, Student $student)
    {
        $validator = Validator::make( $request->all(),[
            'is_finished' => ['required', 'boolean'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $data = [
            'is_finished' => $request->is_finished,
        ];

        $student->update($data);

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Success"
            ]
        ],200);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guidance $guidance)
    {
        //
    }

}
