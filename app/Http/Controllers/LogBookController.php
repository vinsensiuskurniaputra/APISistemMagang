<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\LogBook;
use App\Models\Notification;
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
            "log_books" => $request->user()->student->logBooks()->latest('updated_at')->get()->map(function ($logBook) {
                return [
                    'id' => $logBook->id,
                    'title' => $logBook->title,
                    'activity' => $logBook->activity,
                    'date' => $logBook->date,
                    'lecturer_note' => $logBook->lecturer_note,
                ];
            })
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
            "created_at" => now(),
            "updated_at" => now(),
        ]);

        $message = "Telah Membuat Log Book Baru";
        $category = "log_book";
        Notification::create([
            "user_id" => $request->user()->student->lecturer->user->id,
            "message" => $message,
            "date" => now(),
            "category" => $category,
            "is_read" => 0,
            "create_at" => now(),
            "update_at" => now(),
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

        $data = [
            'title' => $request->title,
            'date' => $request->date,
            'activity' => $request->activity,
            "updated_at" => now(),
        ];

        $logBook->update($data);

        $message = "Telah Mengedit Log Book " . $request->title;
        $category = "log_book";
        Notification::create([
            "user_id" => $request->user()->student->lecturer->user->id,
            "message" => $message,
            "date" => now(),
            "category" => $category,
            "is_read" => 0,
            "create_at" => now(),
            "update_at" => now(),
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

        $message = "Telah Menghapus Log Book";
        $category = "log_book";
        Notification::create([
            "user_id" => $request->user()->student->lecturer->user->id,
            "message" => $message,
            "date" => now(),
            "category" => $category,
            "is_read" => 0,
            "create_at" => now(),
            "update_at" => now(),
        ]);

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Success"
            ]
        ],200);
    }
}