<?php

namespace Database\Factories\About;

use App\Models\Education;
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

    protected $model = Education::class;
    
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-20 years', '-1 year');
        $endDate = $this->faker->dateTimeBetween($startDate, 'now');

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];
    }
}
