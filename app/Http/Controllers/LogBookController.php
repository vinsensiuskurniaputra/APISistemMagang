<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\LogBook;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = [
            "log_books" => $request->user()->student->logBooks()->latest()->get()
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

        LogBook::create([
            "student_id" => $request->user()->student->id,
            "title" => $request->title,
            "activity" => $request->activity,
            "date" => $request->date,
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
    public function show(LogBook $logBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LogBook $logBook)
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

        $logBook->update([
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
    public function destroy(LogBook $logBook)
    {
        $logBook->delete();

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Success"
            ]
        ],200);
    }
}
