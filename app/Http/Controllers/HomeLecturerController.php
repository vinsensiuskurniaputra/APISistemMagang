<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Group;
use App\Models\Archive;

class HomeLecturerController extends Controller
{
    public function index(Request $request)
    {
        $lecturer = $request->user()->lecturer;
        
        $data = [
            "userId" => $request->user()->id,
            "name" => $request->user()->name,
            "students" => $lecturer->students->map(function($student) use ($lecturer) {
                // Check if student is archived for this lecturer
                $isArchived = Archive::where([
                    'student_id' => $student->id, 
                    'lecturer_id' => $lecturer->id,
                    'is_archived' => true
                ])->exists();

                // Get groups for this student
                $groups = $student->groups()->where('lecturer_id', $lecturer->id)->get()->map(function($group) {
                    return [
                        'id' => $group->id,
                        'title' => $group->title,
                        'icon' => $group->icon,
                        'color' => $group->color,
                    ];
                });

                return [
                    "id" => $student->id,
                    "name" => $student->user->name,
                    "username" => $student->user->username,
                    "photo_profile" => $student->user->photo_profile ? asset('storage/'.$student->user->photo_profile) : null,
                    "class" => "{$student->studyProgram->study_program_initials} - {$student->class}",
                    "study_program" => $student->studyProgram->name,
                    "major" => $student->studyProgram->major,
                    "academic_year" => $student->academic_year,
                    "is_finished" => $student->is_finished == 1,
                    "is_archived" => $isArchived,
                    "groups" => $groups,
                    "activities" => [
                        "is_in_progress" => $student->guidances->contains('status', 'in-progress'),
                        "is_updated" => $student->guidances->contains('status', 'updated'),
                        "is_rejected" => $student->guidances->contains('status', 'rejected'),
                    ],
                ];
            }),
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ], 200);
    }

    // Additional methods for archive and group management
    public function archiveStudents(Request $request)
    {
        $lecturer = $request->user()->lecturer;
        $studentIds = $request->input('student_ids', []);

        foreach ($studentIds as $studentId) {
            Archive::updateOrCreate(
                [
                    'student_id' => $studentId, 
                    'lecturer_id' => $lecturer->id
                ],
                ['is_archived' => true]
            );
        }

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "message" => "Students archived successfully"
        ], 200);
    }

    public function unarchiveStudents(Request $request)
    {
        $lecturer = $request->user()->lecturer;
        $studentIds = $request->input('student_ids', []);

        Archive::where('lecturer_id', $lecturer->id)
            ->whereIn('student_id', $studentIds)
            ->update(['is_archived' => false]);

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "message" => "Students unarchived successfully"
        ], 200);
    }

    public function createGroup(Request $request)
    {
        $lecturer = $request->user()->lecturer;
        $group = $lecturer->groups()->create([
            'title' => $request->input('title'),
            'icon' => $request->input('icon'),
            'color' => $request->input('color')
        ]);

        // Attach students to the group
        $studentIds = $request->input('student_ids', []);
        $group->students()->attach($studentIds);

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $group
        ], 200);
    }

    public function updateGroup(Request $request, $groupId)
    {
        $lecturer = $request->user()->lecturer;
        $group = $lecturer->groups()->findOrFail($groupId);

        $group->update([
            'title' => $request->input('title'),
            'icon' => $request->input('icon'),
            'color' => $request->input('color')
        ]);

        // Optionally update students in the group
        $studentIds = $request->input('student_ids');
        if ($studentIds !== null) {
            $group->students()->sync($studentIds);
        }

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $group
        ], 200);
    }

    public function deleteGroup(Request $request, $groupId)
    {
        $lecturer = $request->user()->lecturer;
        $group = $lecturer->groups()->findOrFail($groupId);
        $group->delete();

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "message" => "Group deleted successfully"
        ], 200);
    }
}