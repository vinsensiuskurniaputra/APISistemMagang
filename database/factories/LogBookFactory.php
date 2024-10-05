<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\LogBook>
 */
class LogBookFactory extends Factory
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
            'title' => $this->faker->sentence(6, true), 
            'activity' => $this->faker->paragraph(3, true), 
            'date' => $this->faker->date,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
