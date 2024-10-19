<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\LogBook;
use App\Models\Student;
use App\Models\Guidance;
use App\Models\Industry;
use App\Models\Lecturer;
use App\Models\Internship;
use App\Models\StudyProgram;
use Illuminate\Database\Seeder;
use App\Models\AssessmentComponent;
use App\Models\DetailedAssessmentComponent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Student::factory()->count(10)->create();

        AssessmentComponent::factory(2)->create()->each(function ($component) {
            DetailedAssessmentComponent::factory(3)->create([
                'assessment_components_id' => $component->id,
            ]);
        });


        $lecturers = Lecturer::factory()->count(5)->create();
        
        $studyPrograms = StudyProgram::factory()->count(5)->create();
        
        $students = Student::factory()->count(10)->create(function () use ($lecturers, $studyPrograms){
            $lecturer = $lecturers->random();
            $studyProgram = $studyPrograms->random();
            return [
                'lecturer_id' => $lecturer->id,
                'study_program_id' => $studyProgram->id,
            ];
        });

        LogBook::factory()->count(50)->create(function () use ($students){
            $student = $students->random();
            return [
                'student_id' => $student->id,
            ];
        });

        Guidance::factory()->count(50)->create(function () use ($students){
            $student = $students->random();
            return [
                'student_id' => $student->id,
                'lecturer_id' => $student->lecturer_id,
                'lecturer_note' => null,
            ];
        });

        $industries = Industry::factory(10)->create();

        Internship::factory()->count(20)->create(function () use ($students, $industries){
            $student = $students->random();
            $industry = $industries->random();
            return [
                'student_id' => $student->id,
                'industry_id' => $industry->id,
            ];
        });


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
