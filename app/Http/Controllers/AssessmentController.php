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
        $validator = Validator::make( $request->all(),[
            'detailed_assessment_components_id' => ['required', 'exists:detailed_assessment_components,id'],
            'score' => ['required', 'integer', 'between:0,100'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        if(Assessment::where([['id', $student->id], ['detailed_assessment_components_id', $request->detailed_assessment_components_id]])->exists()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => [
                    "message" => "Assessment Already"
                ]
            ],400);
        }

        Assessment::create([
            "student_id" => $student->id,
            "detailed_assessment_components_id" => $request->detailed_assessment_components_id,
            "score" => $request->score,
        ]);

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Success"
            ]
        ],200);

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

    public function getAssessmentComponentAndDetailAssessmentComponent()
    {
        $data = [
            "assessment_components" => AssessmentComponent::all()->map(function($assessmentComponent){
                return [
                    "name" => $assessmentComponent->name,
                    "detailAssessment" => $assessmentComponent->detailedAssessmentComponents->map(function ($detail) {
                        return [
                            "id" => $detail->id,
                            "information" => $detail->information,
                        ];
                    }),
                ];
            }),
        ];
        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data,
        ],200);
    }
}
