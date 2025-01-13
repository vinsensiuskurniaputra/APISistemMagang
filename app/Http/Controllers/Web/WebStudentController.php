<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use App\Models\Lecturer;
use App\Models\Industry;
use App\Models\StudyProgram;
use App\Models\Internship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebStudentController extends Controller
{
    public function index()
    {
        $students = Student::with(['user', 'studyProgram', 'lecturer', 'internships.industry'])->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $lecturers = Lecturer::with('user')->get();
        $studyPrograms = StudyProgram::all();
        $industries = Industry::all();
        return view('admin.students.create', compact('lecturers', 'studyPrograms', 'industries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'study_program_id' => 'required|exists:study_programs,id',
            'lecturer_id' => 'required|exists:lecturers,id',
            'class' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'industry_id' => 'nullable|exists:industries,id',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        DB::transaction(function () use ($request) {
            // Create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make('polines*2023'),
                'role' => User::ROLES['Student'],
            ]);

            // Create student
            $student = Student::create([
                'user_id' => $user->id,
                'lecturer_id' => $request->lecturer_id,
                'study_program_id' => $request->study_program_id,
                'class' => $request->class,
                'academic_year' => $request->academic_year,
                'is_finished' => false,
            ]);

            // Create internship if industry is selected
            if ($request->filled('industry_id')) {
                Internship::create([
                    'student_id' => $student->id,
                    'industry_id' => $request->industry_id,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                ]);
            }
        });

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully');
    }

    public function edit(Student $student)
    {
        $lecturers = Lecturer::with('user')->get();
        $studyPrograms = StudyProgram::all();
        $industries = Industry::all();
        return view('admin.students.edit', compact('student', 'lecturers', 'studyPrograms', 'industries'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->user_id,
            'username' => 'required|string|unique:users,username,' . $student->user_id,
            'class' => 'required|string|max:255',
            'academic_year' => 'required|string|max:255',
            'study_program_id' => 'required|exists:study_programs,id',
            'lecturer_id' => 'required|exists:lecturers,id',
        ]);

        try {
            DB::beginTransaction();

            // Update user
            $student->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
            ]);

            // Update student
            $student->update([
                'class' => $request->class,
                'academic_year' => $request->academic_year,
                'study_program_id' => $request->study_program_id,
                'lecturer_id' => $request->lecturer_id,
            ]);

            DB::commit();
            return redirect()->route('admin.students.index')
                ->with('success', 'Student updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Error updating student: ' . $e->getMessage()]);
        }
    }

    public function destroy(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->user->delete();
            $student->delete();
        });

        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully');
    }

    public function deleteInternship(Internship $internship)
    {
        echo $internship;
        try {
            $internship->delete();
            return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false, 
                'message' => 'Error deleting internship: ' . $e->getMessage()
            ], 500);
        }
    }
}
