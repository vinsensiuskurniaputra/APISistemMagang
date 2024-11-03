<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Guidance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuidanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $guidances = $request->user()->student->guidances()->latest('updated_at')->get()->map(function ($guidance) {
            return [
                'id' => $guidance->id,
                'title' => $guidance->title,
                'activity' => $guidance->activity,
                'date' => $guidance->date,
                'lecturer_note' => $guidance->lecturer_note,
                'status' => $guidance->status,
                'name_file' => $guidance->name_file != null ? asset('storage/' . $guidance->name_file) : null,
            ];
        });


        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "guidances" => $guidances
            ],
        ],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'title' => ['required'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'activity' => ['required'],
            'name_file' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $data = [
            "student_id" => $request->user()->student->id,
            "lecturer_id" => $request->user()->student->lecturer_id,
            "title" => $request->title,
            "activity" => $request->activity,
            "date" => $request->date,
            "status" => 'in-progress',
            "created_at" => now(),
            "updated_at" => now(),
        ];

        if($request->hasFile('name_file')){
            $data['name_file'] = $request->file('name_file')->store('guidance_file', 'public');
        }

        Guidance::create($data);

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
            'name_file' => ['nullable', 'file', 'max:2048', 'mimes:pdf'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $data = [
            'title' => $request->title,
            'date' => $request->date,
            'activity' => $request->activity,
            "updated_at" => now(),
        ];

        if($request->hasFile('name_file')){
            $data['name_file'] = $request->file('name_file')->store('guidance_file', 'public');
        }

        if($guidance->status == "rejected"){
            $data['status'] = "updated";
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Guidance $guidance)
    {
        if ($guidance->name_file) {
            Storage::disk('public')->delete($guidance->name_file);
        }

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
