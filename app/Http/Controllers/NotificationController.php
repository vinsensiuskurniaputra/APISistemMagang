<?php

namespace App\Http\Controllers;

use Validator;
use Carbon\Carbon;
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
            'user_id' => ['required', 'array'], // Mengharuskan user_id sebagai array
            'user_id.*' => ['required', 'exists:users,id'], // Validasi tiap elemen array agar ada di tabel users
            'message' => ['required', 'string'],
            'date' => [
                'required',
                'date',
                'date_format:Y-m-d',
                function ($attribute, $value, $fail) {
                    $today = Carbon::now('Asia/Jakarta')->format('Y-m-d');
                    if ($value > $today) {
                        $fail("The $attribute field must be a date before or equal to today.");
                    }
                },
            ],
            'category' => ['required', 'string', 'in:guidance,general,log_book,revisi'],
            'detail_text' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ], 400);
        }

        // Loop untuk membuat notifikasi ke setiap user_id
        $userIds = $request->user_id;
        $notifications = [];

        foreach ($userIds as $userId) {
            $data = [
                "user_id" => $userId,
                "message" => $request->message,
                "date" => $request->date,
                "category" => $request->category,
                "is_read" => false,
                "detail_text" => $request->detail_text ?? null,
                "created_at" => now(),
                "updated_at" => now(),
            ];

            // Simpan data notifikasi
            $notifications[] = Notification::create($data);
        }

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Notifications created successfully",
                "notifications" => $notifications
            ]
        ], 200);
    }


    public function markAsRead(Request $request)
    {
        $request->user()->notifications()->where('is_read', false)->update(['is_read' => true]);
        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Notification mark as read successfully"
            ]
        ], 200);
    }



}
