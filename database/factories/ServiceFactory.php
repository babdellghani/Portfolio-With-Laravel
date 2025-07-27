<?php

namespace Database\Factories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Service>
 */
class ServiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Service::class;
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->unique()->slug(),
            'icon' => 'defaults_images/portfolio_services_img.jpg',
            'image' => 'defaults_images/portfolio_services_details.jpg',
            'short_description' => $this->faker->text(200),
            'description' => $this->faker->randomHtml(6, 10) . 
                '<img src="' . $this->faker->imageUrl(800, 400, 'business') . '" alt="Service Image" class="img-fluid my-3">' .
                '<h1>' . $this->faker->sentence(4) . '</h1>' .
                '<p>' . $this->faker->paragraphs(2, true) . '</p>' .
                '<h2>' . $this->faker->sentence(3) . '</h2>' .
                '<p>' . $this->faker->paragraphs(3, true) . '</p>' .
                '<img src="' . $this->faker->imageUrl(600, 300, 'business') . '" alt="Service Detail" class="img-fluid my-3">' .
                '<h3>' . $this->faker->sentence(2) . '</h3>' .
                '<p>' . $this->faker->paragraphs(2, true) . '</p>',
        ];
    }
}