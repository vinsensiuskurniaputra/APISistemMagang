<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\StudyProgram;
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
        
        
        
        $academic_years = ['2023/2024', '2024/2025', '2025/2026'];
        $class = ['3A', '3B', '3C', '2C'];
        
        return [
            'user_id' => User::factory()->create(['role' => 'Student'])->id,
            'lecturer_id' => Lecturer::factory(),
            'study_program_id' => StudyProgram::factory(),
            'class' => $this->faker->randomElement($class),
            'academic_year' => $this->faker->randomElement($academic_years),
            'created_at' => now(),
            'updated_at' => now(),
        ];

    }
}
