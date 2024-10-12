<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Industry;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Internship>
 */
class InternshipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->date();
        return [
            'student_id' => Student::factory(),
            'industry_id' => Industry::factory(),
            'start_date' => $startDate,
            'end_date' => $this->faker->optional()->dateTimeBetween($startDate, '+6 months'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
