<?php
namespace Database\Factories;

use App\Models\Blog;
use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bookmark>
 */
class BookmarkFactory extends Factory
{
    protected $model = Bookmark::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::where('status', 'active')->inRandomOrder()->first()?->id ?? User::factory()->create()->id,
            'blog_id' => Blog::where('status', true)->inRandomOrder()->first()?->id ?? Blog::factory()->published()->create()->id,
        ];
    }

    /**
     * Create a bookmark for a specific blog
     */
    public function forBlog(Blog $blog): static
    {
        return $this->state(fn(array $attributes) => [
            'blog_id' => $blog->id,
        ]);
    }

    /**
     * Create a bookmark by a specific user
     */
    public function byUser(User $user): static
    {
        return $this->state(fn(array $attributes) => [
            'user_id' => $user->id,
        ]);
    }
}
