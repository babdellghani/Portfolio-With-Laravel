<?php
namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Portfolio>
 */
class PortfolioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Portfolio::class;
    public function definition(): array
    {
        return [
            'title'             => $this->faker->sentence(3),
            'slug'              => $this->faker->unique()->slug(),
            'image'             => 'defaults_images/portfolio_services_details.jpg',
            'short_description' => $this->faker->text(200),
            'description'       => $this->faker->randomHtml(2, 3) . '<img src="' . $this->faker->imageUrl(600, 400, 'business') . '" alt="Portfolio image" class="img-fluid my-3">' . $this->faker->randomHtml(2, 3),
            'status'            => $this->faker->boolean(),
            'category'          => $this->faker->randomElements(['Web Development', 'Mobile App', 'UI/UX Design', 'E-commerce', 'Branding', 'Digital Marketing'], $this->faker->numberBetween(1, 3)),
            'date'              => $this->faker->date(),
            'location'          => $this->faker->city(),
            'client'            => $this->faker->company(),
            'link'              => $this->faker->url(),
        ];
    }
}