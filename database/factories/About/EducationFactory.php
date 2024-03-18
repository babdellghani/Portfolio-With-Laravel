<?php

namespace Database\Factories\About;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->year();
        $endDate = $this->faker->year($startDate);

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(50),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
