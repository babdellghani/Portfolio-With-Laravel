<?php
namespace Database\Factories;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    protected $model = Blog::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6, true);
        $slug  = Str::slug($title);

        return [
            'title'             => $title,
            'slug'              => $slug,
            'short_description' => $this->faker->text(200),
            'description'       => $this->faker->paragraphs(5, true),
            'image'             => 'defaults_images/blog/blog_' . $this->faker->numberBetween(1, 10) . '.jpg',
            'status'            => $this->faker->boolean(80), // 80% chance of being published
            'user_id'           => User::where('email_verified_at', '!=', null)->where('status', 'active')->inRandomOrder()->first()?->id ?? User::factory(),
        ];
    }

    /**
     * Create a published blog post
     */
    public function published(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => true,
        ]);
    }

    /**
     * Create a draft blog post
     */
    public function draft(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => false,
        ]);
    }

    /**
     * Create a blog post by a specific user
     */
    public function byUser(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
