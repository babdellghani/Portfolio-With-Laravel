<?php
namespace Database\Factories;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tags = [
            'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js', 'Node.js',
            'CSS', 'HTML', 'Bootstrap', 'Tailwind', 'MySQL', 'PostgreSQL',
            'API', 'REST', 'GraphQL', 'Docker', 'Git', 'GitHub',
            'Frontend', 'Backend', 'Full-stack', 'Mobile', 'Web',
            'UI', 'UX', 'Design', 'SEO', 'Marketing', 'E-commerce',
            'Tutorial', 'Tips', 'Guide', 'Best Practices', 'Review',
        ];

        $name = $this->faker->randomElement($tags) . ' ' . $this->faker->unique()->numberBetween(1, 1000);
        $slug = Str::slug($name);

        return [
            'name'    => $name,
            'slug'    => $slug,
            'status'  => $this->faker->boolean(95), // 95% chance of being active
            'user_id' => User::where('role', 'admin')->inRandomOrder()->first()?->id ?? User::factory()->admin(),
        ];
    }

    /**
     * Create an active tag
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => true,
        ]);
    }

    /**
     * Create an inactive tag
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => false,
        ]);
    }
}
