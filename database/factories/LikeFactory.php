<?php
namespace Database\Factories;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    protected $model = Like::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $likeableType = $this->faker->randomElement([Blog::class, Comment::class]);

        if ($likeableType === Blog::class) {
            $likeable = Blog::where('status', true)->inRandomOrder()->first() ?? Blog::factory()->published()->create();
        } else {
            $likeable = Comment::where('status', true)->inRandomOrder()->first() ?? Comment::factory()->active()->create();
        }

        return [
            'user_id'       => User::where('status', 'active')->inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'likeable_id'   => $likeable->id,
            'likeable_type' => $likeableType,
        ];
    }

    /**
     * Create a like for a blog
     */
    public function forBlog(Blog $blog): static
    {
        return $this->state(fn(array $attributes) => [
            'likeable_id'   => $blog->id,
            'likeable_type' => Blog::class,
        ]);
    }

    /**
     * Create a like for a comment
     */
    public function forComment(Comment $comment): static
    {
        return $this->state(fn(array $attributes) => [
            'likeable_id'   => $comment->id,
            'likeable_type' => Comment::class,
        ]);
    }

    /**
     * Create a like by a specific user
     */
    public function byUser(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
