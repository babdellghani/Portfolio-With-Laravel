<?php

namespace Database\Factories\About;

use App\Models\Award;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Award>
 */
class AwardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Award::class;
    
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(10),
            'year' => $this->faker->year(),
            'image' => 'defaults_images/awards_0' . $this->faker->numberBetween(1, 4) . '.png',
        ];
    }
}
