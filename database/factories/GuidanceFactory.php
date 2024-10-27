<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guidance>
 */
class GuidanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $statuses = ['approved', 'rejected', 'in-progress', 'updated'];

        return [
            'student_id' => Student::factory(),
            'lecturer_id' => Lecturer::factory(),
            'title' => $this->faker->sentence(6, true),
            'activity' => $this->faker->sentence(10, true),
            'date' => $this->faker->date,
            'lecturer_note' => $this->faker->paragraph(3, true),
            'name_file' => null, 
            'status' => $this->faker->randomElement($statuses),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
