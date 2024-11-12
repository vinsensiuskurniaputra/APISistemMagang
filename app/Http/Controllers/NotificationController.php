<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request){
        $data = [
            "notifications" => $request->user()->notifications()->latest()->get(),
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'student_id' => ['required', 'exists:students,id'],
            'message' => ['required', 'string'],
            'date' => ['required', 'date', 'date_format:Y-m-d', 'before_or_equal:today'],
            'category' => ['required', 'string', 'in:info,warning,alert'],
            'detail_text' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ], 400);
        }

        $data = [
            "student_id" => $request->student_id,
            "message" => $request->message,
            "date" => $request->date,
            "category" => $request->category,
            "is_read" => false,
            "detail_text" => $request->detail_text ?? null,
            "created_at" => now(),
            "updated_at" => now(),
        ];

        Notification::create($data);

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Notification created successfully"
            ]
        ], 200);
    }

}
