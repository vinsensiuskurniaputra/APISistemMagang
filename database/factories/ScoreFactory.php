<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Score>
 */
class ScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'lecturer_score' => $this->faker->numberBetween(50, 100),
            'industy_score' => $this->faker->numberBetween(50, 100), 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
