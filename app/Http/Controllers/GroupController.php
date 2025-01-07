<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupStudent;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groups = $request->user()->lecturer->groups->map(function ($group) {
            return [
                'id' => $group->id,
                'title' => $group->title,
                'icon' => $group->icon,
                'color' => $group->color,
                'student_count' => $group->groupStudents->count()
            ];
        });

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "groups" => $groups
            ],
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(),[
            'student_id' => ['required', 'array'], 
            'student_id.*' => ['required', 'exists:students,id'], 
            'title' => ['required'],
            'icon' => ['required'],
            'color' => ['required'],
        ]);

        if($validator->fails()){
            return response()->json([
                "code" => "400",
                "status" => "BAD_REQUEST",
                "errors" => $validator->errors()
            ],400);
        }

        $data = [
            "lecturer_id" => $request->user()->lecturer->id,
            "title" => $request->title,
            "icon" => $request->icon,
            "color" => $request->color,
            "created_at" => now(),
            "updated_at" => now(),
        ];

        $newGroup = Group::create($data);

        $studentIds = $request->student_id;

        $studentData = collect($studentIds)->map(function ($studentId) use ($newGroup) {
            return [
                "group_id" => $newGroup->id,
                "student_id" => $studentId,
                "created_at" => now(),
                "updated_at" => now(),
            ];
        })->toArray();

        GroupStudent::insert($studentData);


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
    public function show(Group $group)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Group $group)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Group $group)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Group $group)
    {
        if (!$group) {
            return response()->json([
                "code" => "404",
                "status" => "NOT_FOUND",
                "errors" => [
                    "message" => "Group not found"
                ]
            ], 404);
        }
        // Hapus semua relasi di GroupStudent
        $group->groupStudents()->delete();

        // Hapus grup
        $group->delete();

        // Kembalikan respon sukses
        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => [
                "message" => "Group deleted successfully"
            ]
        ], 200);
    }
}
