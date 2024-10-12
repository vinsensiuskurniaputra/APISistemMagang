<?php

namespace Database\Factories;

use App\Models\AssessmentComponent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetailedAssessmentComponent>
 */
class DetailedAssessmentComponentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'assessment_components_id' => AssessmentComponent::factory(),
            'information' => $this->faker->sentence(8, true),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
