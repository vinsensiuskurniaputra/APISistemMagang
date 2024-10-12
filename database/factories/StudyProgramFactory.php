<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudyProgram>
 */
class StudyProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'study_program_initials' => strtoupper($this->faker->lexify('???')), // Generate random initials
            'pddikti_code' => $this->faker->numerify('#####'), // Generate a random 5-digit code
            'level' => $this->faker->randomElement(['D3', 'S1', 'S2']), // Example levels
            'major' => $this->faker->randomElement(['Informatics', 'Electrical Engineering', 'Mechanical Engineering']), // Example majors
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
