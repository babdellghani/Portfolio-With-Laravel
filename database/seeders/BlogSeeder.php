<?php
namespace Database\Seeders;

use App\Models\Blog;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get admin user and other active users
        $adminUser   = User::where('role', 'admin')->first();
        $activeUsers = User::where('status', true)->where('role', '!=', 'admin')->take(5)->get();

        if (! $adminUser) {
            throw new \Exception('Admin user not found. Make sure UserSeeder runs before BlogSeeder.');
        }

        // Get all categories and tags
        $categories = Category::all();
        $tags       = Tag::all();

        if ($categories->isEmpty() || $tags->isEmpty()) {
            throw new \Exception('Categories or tags not found. Make sure CategorySeeder and TagSeeder run before BlogSeeder.');
        }

        // Create 20 blog posts
        Blog::factory(20)->create([
            'user_id' => $adminUser->id,
            'status'  => 'published',
        ])->each(function ($blog) use ($categories, $tags, $activeUsers) {
            // Attach random categories (1-3 categories per blog)
            $randomCategories = $categories->random(rand(1, 3));
            $blog->categories()->attach($randomCategories->pluck('id'));

            // Attach random tags (2-5 tags per blog)
            $randomTags = $tags->random(rand(2, 5));
            $blog->tags()->attach($randomTags->pluck('id'));

            // Create comments for each blog
            $this->createCommentsForBlog($blog, $activeUsers);

            // Create likes for blog posts
            $this->createLikesForBlog($blog, $activeUsers);

            // Create bookmarks for blog posts
            $this->createBookmarksForBlog($blog, $activeUsers);
        });

        // Create some draft posts
        Blog::factory(5)->create([
            'user_id' => $adminUser->id,
            'status'  => 'draft',
        ])->each(function ($blog) use ($categories, $tags) {
            // Attach random categories and tags
            $randomCategories = $categories->random(rand(1, 2));
            $blog->categories()->attach($randomCategories->pluck('id'));

            $randomTags = $tags->random(rand(1, 3));
            $blog->tags()->attach($randomTags->pluck('id'));
        });
    }

    /**
     * Create comments for a blog post with nested replies
     */
    private function createCommentsForBlog(Blog $blog, $users)
    {
        // Create 2-5 top-level comments
        $topLevelComments = Comment::factory(rand(2, 5))->create([
            'blog_id'   => $blog->id,
            'user_id'   => $users->random()->id,
            'parent_id' => null,
            'status'    => true,
        ]);

        // Create replies for some comments
        foreach ($topLevelComments as $comment) {
            // 50% chance to have replies
            if (rand(0, 1)) {
                $replies = Comment::factory(rand(1, 3))->create([
                    'blog_id'   => $blog->id,
                    'user_id'   => $users->random()->id,
                    'parent_id' => $comment->id,
                    'status'    => true,
                ]);

                // Create nested replies (2nd level)
                foreach ($replies as $reply) {
                    // 30% chance for 2nd level replies
                    if (rand(0, 10) <= 3) {
                        Comment::factory(rand(1, 2))->create([
                            'blog_id'   => $blog->id,
                            'user_id'   => $users->random()->id,
                            'parent_id' => $reply->id,
                            'status'    => true,
                        ]);
                    }
                }
            }
        }

        // Create likes for comments
        $allComments = $blog->comments;
        foreach ($allComments as $comment) {
            // Random users like comments (30% chance)
            $likingUsers = $users->random(rand(0, min(3, $users->count())));
            foreach ($likingUsers as $user) {
                if (rand(0, 10) <= 3) {
                    Like::factory()->create([
                        'user_id'       => $user->id,
                        'likeable_type' => Comment::class,
                        'likeable_id'   => $comment->id,
                    ]);
                }
            }
        }
    }

    /**
     * Create likes for a blog post
     */
    private function createLikesForBlog(Blog $blog, $users)
    {
        // Random users like the blog post (60% chance)
        $likingUsers = $users->random(rand(1, min(4, $users->count())));
        foreach ($likingUsers as $user) {
            if (rand(0, 10) <= 6) {
                Like::factory()->create([
                    'user_id'       => $user->id,
                    'likeable_type' => Blog::class,
                    'likeable_id'   => $blog->id,
                ]);
            }
        }
    }

    /**
     * Create bookmarks for a blog post
     */
    private function createBookmarksForBlog(Blog $blog, $users)
    {
        // Random users bookmark the blog post (40% chance)
        $bookmarkingUsers = $users->random(rand(0, min(3, $users->count())));
        foreach ($bookmarkingUsers as $user) {
            if (rand(0, 10) <= 4) {
                Bookmark::factory()->create([
                    'user_id' => $user->id,
                    'blog_id' => $blog->id,
                ]);
            }
        }
    }
}
