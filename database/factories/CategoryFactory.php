<?php
namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $categories = [
            'Web Development',
            'Mobile Development',
            'UI/UX Design',
            'Digital Marketing',
            'SEO',
            'Content Writing',
            'Photography',
            'Graphic Design',
            'E-commerce',
            'Technology',
            'Programming',
            'Laravel',
            'PHP',
            'JavaScript',
            'React',
            'Vue.js',
        ];

        $name = $this->faker->randomElement($categories) . ' ' . $this->faker->unique()->numberBetween(1, 1000);
        $slug = Str::slug($name);

        return [
            'name'        => $name,
            'slug'        => $slug,
            'image'       => 'defaults_images/category/category_' . $this->faker->numberBetween(1, 5) . '.jpg',
            'description' => $this->faker->paragraph(),
            'status'      => $this->faker->boolean(90), // 90% chance of being active
            'user_id'     => User::where('role', 'admin')->inRandomOrder()->first()?->id ?? User::factory()->admin(),
        ];
    }

    /**
     * Create an active category
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => true,
        ]);
    }

    /**
     * Create an inactive category
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => false,
        ]);
    }
}
