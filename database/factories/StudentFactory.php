<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $studyPrograms = [
            'Teknik Informatika',
            'Teknik Sipil',
            'Manajemen',
            'Ekonomi',
            'Psikologi',
            'Sistem Informasi',
            'Desain Komunikasi Visual',
            'Ilmu Komunikasi',
        ];

        $majors = [
            'Software Engineering',
            'Structural Engineering',
            'Marketing Management',
            'Business Economics',
            'Clinical Psychology',
            'Information Systems',
            'Graphic Design',
            'Public Relations',
        ];
        
        $academic_year = ['2023/2024', '2024/2025', '2025/2026'];
        
        return [
            'user_id' => User::factory([
                'role' => 'Student'
            ]), 
            'lecturer_id' => Lecturer::factory(), 
            'class' => $this->faker->randomElement(['A1', 'B2', 'C3', 'D4', 'E5']),
            'study_program' => $this->faker->randomElement($studyPrograms),
            'major' => $this->faker->randomElement($majors),
            'academic_year' => $this->faker->randomElement($academic_year),
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }
}
