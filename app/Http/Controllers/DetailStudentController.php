<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\LogBook;
use App\Models\Student;
use App\Models\Guidance;
use App\Models\Assessment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\AssessmentComponent;
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
            "photo_profile" => $student->user->photo_profile ? asset('storage/'.$student->user->photo_profile ) : null,
            "email" => $student->user->email,
            "major" => $student->studyProgram->major,
            "class" => "{$student->studyProgram->study_program_initials} - {$student->class}",
            "is_finished" => $student->is_finished,
        ];
        
        // Ambil semua komponen penilaian beserta sub komponen
        $components = AssessmentComponent::with('detailedComponents')->get();

        // Ambil semua nilai yang sudah dimiliki siswa
        $existingAssessments = Assessment::where('student_id', $student->id)
            ->pluck('score', 'detailed_assessment_component_id');

        // Map data komponen penilaian beserta sub komponen dan nilai
        $scoresAssessments = $components->map(function ($component) use ($existingAssessments) {
            // Mendapatkan nilai untuk setiap sub komponen
            $scores = $component->detailedComponents->map(function ($detailedComponent) use ($existingAssessments) {
                return [
                    'id' => $detailedComponent->id,
                    'name' => $detailedComponent->information,
                    'score' => $existingAssessments->get($detailedComponent->id, null) // Nilai default null jika belum ada
                ];
            });

            // Menghitung rata-rata nilai dari sub komponen
            $averageScore = $scores->filter(function ($score) {
                return $score['score'] !== null; // Mengabaikan nilai yang null
            })->avg('score'); // Menghitung rata-rata dari nilai yang ada

            $averageScore = round($averageScore, 2);

            return [
                'component_name' => $component->name,
                'average_score' => $averageScore // Menambahkan rata-rata nilai
            ];
        });

        $average_all_assessments = $scoresAssessments->filter(function ($score) {
                return $score['average_score'] !== null; // Mengabaikan nilai yang null
            })->avg('average_score');
        $average_all_assessments = round($average_all_assessments, 2);

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
            "assessments" => $scoresAssessments,
            "average_all_assessments" => $average_all_assessments,
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

    public function addNoteLogBook(Request $request, LogBook $logBook)
    {
        $validator = Validator::make( $request->all(),[
            'lecturer_note' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $data = [
            'lecturer_note' => $request->lecturer_note,
            'updated_at' => now(),
        ];

        $logBook->update($data);

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
