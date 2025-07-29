<?php
namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Testimonial>
 */
class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'    => $this->faker->name(),
            'title'   => $this->faker->jobTitle(),
            'message' => $this->faker->paragraph(3),
            'image'   => 'defaults_images/testi_img0' . $this->faker->numberBetween(1, 7) . '.png',
            'rating'  => $this->faker->numberBetween(4, 5),
            'status'  => true,
        ];
    }
}
