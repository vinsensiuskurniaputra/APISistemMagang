<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Assessment>
 */
class AssessmentFactory extends Factory
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
            'detailed_assessment_component_id' => DetailedAssessmentComponent::factory(),
            'score' => $this->faker->numberBetween(50, 100),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
