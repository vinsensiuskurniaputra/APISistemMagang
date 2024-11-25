<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Student;
use App\Models\Assessment;
use Illuminate\Http\Request;
use App\Models\AssessmentComponent;
use App\Http\Controllers\Controller;

class AssessmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Student $student)
    {
        $validator = Validator::make($request->all(), [
            'scores' => ['required', 'array'],
            'scores.*.detailed_assessment_components_id' => ['required', 'exists:detailed_assessment_components,id'],
            'scores.*.score' => ['required', 'integer', 'between:0,100'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ], 400);
        }

        $assessments = [];
        foreach ($request->scores as $scoreData) {
            // Cek apakah nilai untuk komponen ini sudah ada
            if (Assessment::where([
                ['student_id', $student->id],
                ['detailed_assessment_components_id', $scoreData['detailed_assessment_components_id']]
            ])->exists()) {
                continue; // Skip jika sudah ada
            }

            $assessments[] = [
                'student_id' => $student->id,
                'detailed_assessment_components_id' => $scoreData['detailed_assessment_components_id'],
                'score' => $scoreData['score'],
                'created_at' => now(),
                'updated_at' => now()
            ];
        }

        if (!empty($assessments)) {
            // Batch insert sekaligus
            Assessment::insert($assessments);
        }

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Success"
            ]
        ], 200);
    }


    /**
     * Display the specified resource.
     */
    public function show(Assessment $assessment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Assessment $assessment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Assessment $assessment)
    {
        //
    }

    // public function getAssessmentComponentAndDetailAssessmentComponent()
    // {
    //     $data = [
    //         "assessment_components" => AssessmentComponent::all()->map(function($assessmentComponent){
    //             return [
    //                 "name" => $assessmentComponent->name,
    //                 "detailAssessment" => $assessmentComponent->detailedAssessmentComponents->map(function ($detail) {
    //                     return [
    //                         "id" => $detail->id,
    //                         "information" => $detail->information,
    //                     ];
    //                 }),
    //             ];
    //         }),
    //     ];
    //     return response()->json([
    //         "code" => "200",
    //         "status" => "OK",
    //         "data" => $data,
    //     ],200);
    // }

    public function getStudentAssessments(Student $student)
    {
        // Ambil semua komponen penilaian beserta sub komponen
        $components = AssessmentComponent::with('detailedComponents')->get();

        // Ambil semua nilai yang sudah dimiliki siswa
        $existingAssessments = Assessment::where('student_id', $student->id)
            ->pluck('score', 'detailed_assessment_component_id');

        // Map data komponen penilaian beserta sub komponen dan nilai
        $result = $components->map(function ($component) use ($existingAssessments) {
            $scores = $component->detailedComponents->map(function ($detailedComponent) use ($existingAssessments) {
                return [
                    'id' => $detailedComponent->id,
                    'name' => $detailedComponent->information,
                    'score' => $existingAssessments->get($detailedComponent->id, null) // Nilai default 0 jika belum ada
                ];
            });

            return [
                'component_name' => $component->name,
                'scores' => $scores
            ];
        });

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $result
        ], 200);
    }


}
