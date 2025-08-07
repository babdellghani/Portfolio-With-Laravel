<?php
namespace Database\Factories;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'Great article! Thanks for sharing.',
            'This is very helpful, learned a lot.',
            'Could you provide more details about this topic?',
            'I have a different perspective on this.',
            'Excellent explanation, very clear and concise.',
            'This helped me solve my problem, thank you!',
            'I disagree with some points, but overall good content.',
            'Any updates on this topic?',
            'This is exactly what I was looking for.',
            'Can you recommend any related resources?',
        ];

        return [
            'blog_id'   => Blog::where('status', true)->inRandomOrder()->first()?->id ?? Blog::factory()->published(),
            'user_id'   => User::where('status', 'active')->inRandomOrder()->first()?->id ?? User::factory(),
            'parent_id' => null, // Will be set for replies
            'content'   => $this->faker->randomElement($comments) . ' ' . $this->faker->sentence(),
            'status'    => $this->faker->boolean(95), // 95% chance of being active
        ];
    }

    /**
     * Create a reply comment
     */
    public function reply(Comment $parentComment): static
    {
        return $this->state(fn(array $attributes) => [
            'blog_id'   => $parentComment->blog_id,
            'parent_id' => $parentComment->id,
        ]);
    }

    /**
     * Create an active comment
     */
    public function active(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => true,
        ]);
    }

    /**
     * Create an inactive comment
     */
    public function inactive(): static
    {
        return $this->state(fn(array $attributes) => [
            'status' => false,
        ]);
    }

    /**
     * Create comment for specific blog
     */
    public function forBlog(Blog $blog): static
    {
        return $this->state(fn(array $attributes) => [
            'blog_id' => $blog->id,
        ]);
    }
}
