<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Guidance;
use Illuminate\Http\Request;

class GuidanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [
            "guidances" => $request->user()->student->guidances()->latest()->get()
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'title' => ['required'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'activity' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        Guidance::create([
            "student_id" => $request->user()->student->id,
            "lecturer_id" => $request->user()->student->lecturer_id,
            "title" => $request->title,
            "activity" => $request->activity,
            "date" => $request->date,
            "status" => 'in-progress',
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
    public function show(Guidance $guidance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Guidance $guidance)
    {
        $validator = Validator::make( $request->all(),[
            'title' => ['required'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'activity' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $guidance->update([
            'title' => $request->title,
            'date' => $request->date,
            'activity' => $request->activity,
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
     * Remove the specified resource from storage.
     */
    public function destroy(Guidance $guidance)
    {
        $guidance->delete();

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Success"
            ]
        ],200);
    }
}
