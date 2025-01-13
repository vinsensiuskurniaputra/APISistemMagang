<?php

namespace App\Http\Controllers\Web;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\Guidance;
use App\Models\LogBook;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WebDashboardController extends Controller
{
    public function index()
    {
        // Get counts from database
        $totalStudents = Student::count();
        $totalGuidance = Guidance::count();
        $totalLecturers = Lecturer::count();

        // Get recent activities (combine logbooks and guidances)
        $recentLogbooks = LogBook::with('student')
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function ($logbook) {
                $timeString = $logbook->updated_at->gt($logbook->created_at) 
                    ? 'Updated ' . $logbook->updated_at->diffForHumans()
                    : 'Created ' . $logbook->created_at->diffForHumans();
                
                return [
                    'type' => 'logbook',
                    'title' => $logbook->updated_at->gt($logbook->created_at) ? 'Updated Logbook Entry' : 'New Logbook Entry',
                    'description' => $logbook->student->user->name . ' ' . strtolower($timeString),
                    'time' => $timeString,
                    'icon' => 'book',
                    'color' => $logbook->updated_at->gt($logbook->created_at) ? 'yellow' : 'blue'
                ];
            });

        $recentGuidances = Guidance::with('student')
            ->latest('updated_at')
            ->take(5)
            ->get()
            ->map(function ($guidance) {
                $timeString = $guidance->updated_at->gt($guidance->created_at)
                    ? 'Updated ' . $guidance->updated_at->diffForHumans()
                    : 'Created ' . $guidance->created_at->diffForHumans();

                return [
                    'type' => 'guidance',
                    'title' => 'Guidance ' . ucfirst($guidance->status),
                    'description' => $guidance->student->user->name . "'s guidance " . 
                        ($guidance->updated_at->gt($guidance->created_at) ? 'updated' : 'created'),
                    'time' => $timeString,
                    'icon' => 'comments',
                    'color' => $this->getStatusColor($guidance->status)
                ];
            });

        // Merge and sort activities by most recent update/creation
        $recentActivities = $recentLogbooks->concat($recentGuidances)
            ->sortByDesc(function ($activity) {
                // Extract timestamp from the time string for sorting
                return strtotime(str_replace(['Updated ', 'Created ', ' ago'], '', $activity['time']));
            })
            ->take(5)
            ->values()
            ->all();

        $dashboardData = [
            'totalStudents' => $totalStudents,
            'activeInternships' => $totalGuidance,
            'totalLecturers' => $totalLecturers,
            'recentActivities' => $recentActivities
        ];

        return view('admin.dashboard', compact('dashboardData'));
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'approved' => 'green',
            'rejected' => 'red',
            'in-progress' => 'yellow',
            'updated' => 'purple',
            default => 'gray'
        };
    }
}
