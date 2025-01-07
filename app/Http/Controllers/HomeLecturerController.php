<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\LogBook;
use Carbon\Carbon;

class HomeLecturerController extends Controller
{
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

        $data = [
            "userId" => $request->user()->id,
            "name" => $request->user()->name,
            "students" => $request->user()->lecturer->students->map(function($student){
                // Cek logbook terbaru
                $latestLogbook = $student->logBooks()
                    ->latest('updated_at')
                    ->first();
                
                // Cek guidance terbaru    
                $latestGuidance = $student->guidances()
                    ->latest('updated_at')
                    ->first();
                
                // Bandingkan untuk mendapatkan last updated
                $lastUpdated = null;
                if ($latestLogbook && $latestGuidance) {
                    $lastUpdated = $latestLogbook->updated_at->gt($latestGuidance->updated_at) 
                        ? $latestLogbook->updated_at 
                        : $latestGuidance->updated_at;
                } elseif ($latestLogbook) {
                    $lastUpdated = $latestLogbook->updated_at;
                } elseif ($latestGuidance) {
                    $lastUpdated = $latestGuidance->updated_at;
                }

                // Cek logbook baru dalam 24 jam terakhir
                $hasNewLogbook = $student->logBooks()
                    ->where('created_at', '>=', Carbon::now()->subHours(24))
                    ->exists();

                return [
                    "id" => $student->id,
                    "user_id" => $student->user->id,
                    "name" => $student->user->name,
                    "username" => $student->user->username,
                    "photo_profile" => $student->user->photo_profile ? asset('storage/'.$student->user->photo_profile ) : null,
                    "class" => "{$student->studyProgram->study_program_initials} - {$student->class}",
                    "study_program" => $student->studyProgram->name,
                    "major" => $student->studyProgram->major,
                    "academic_year" => $student->academic_year,
                    "is_finished" => $student->is_finished == 1,
                    "activities" => [
                        "is_in_progress" => $student->guidances->contains('status', 'in-progress'),
                        "is_updated" => $student->guidances->contains('status', 'updated'),
                        "is_rejected" => $student->guidances->contains('status', 'rejected'),
                    ],
                    "hasNewLogbook" => $hasNewLogbook,
                    "lastUpdated" => $lastUpdated ? $lastUpdated->toISOString() : null,
                ];
            }),
            "groups" => $groups,
        ];

        return response()->json([
            "code" => "200",
            "status" => "OK",
            "data" => $data
        ],200);
    }
}