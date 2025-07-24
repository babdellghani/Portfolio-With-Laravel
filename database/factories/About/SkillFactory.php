<?php

namespace Database\Factories\About;

use App\Models\Skill;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Skill>
 */
class SkillFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Skill::class;
    
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(3),
            'value' => $this->faker->numberBetween(0, 100),
        ];
    }
}
