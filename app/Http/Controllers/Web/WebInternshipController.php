<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Internship;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebInternshipController extends Controller
{
    public function store(Request $request, Student $student)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        try {
            $internship = Internship::create([
                'student_id' => $student->id,
                'industry_id' => $request->industry_id,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Internship added successfully',
                'data' => $internship
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error adding internship: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy(Internship $internship)
    {
        try {
            DB::beginTransaction();
            $internship->delete();
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Internship deleted successfully'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error deleting internship: ' . $e->getMessage()
            ], 500);
        }
    }
}
