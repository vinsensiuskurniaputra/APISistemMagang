<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Score;
use App\Models\LogBook;
use App\Models\Student;
use App\Models\Guidance;
use App\Models\Industry;
use App\Models\Lecturer;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\Student::factory()->count(10)->create();


        $lecturers = Lecturer::factory()->count(5)->create();

        $students = Student::factory()->count(10)->create(function () use ($lecturers){
            $lecturer = $lecturers->random();
            return [
                'lecturer_id' => $lecturer->id,
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
            ];
        });

        Score::factory()->count(30)->create(function () use ($students){
            $student = $students->random();
            return [
                'student_id' => $student->id,
            ];
        });

        Industry::factory()->count(20)->create(function () use ($students){
            $student = $students->random();
            return [
                'student_id' => $student->id,
            ];
        });

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
