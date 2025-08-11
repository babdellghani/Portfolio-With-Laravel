<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of blogs for admin
     */
    public function index(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can manage blogs.');
        }

        $query = Blog::with(['user', 'categories', 'tags'])
            ->withCount(['comments', 'likes', 'bookmarks'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('categories.id', $request->category_id);
            });
        }

        // Filter by author
        if ($request->filled('author_id')) {
            $query->where('user_id', $request->author_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('content', 'like', "%{$searchTerm}%")
                    ->orWhere('excerpt', 'like', "%{$searchTerm}%");
            });
        }

        $blogs      = $query->paginate(15);
        $categories = Category::active()->get();
        $authors    = User::whereHas('blogs')->get();

        return view('admin.blogs.index', compact('blogs', 'categories', 'authors'));
    }

    /**
     * Show the form for creating a new blog
     */
    public function create()
    {
        if (! Auth::user()->canCreateBlog()) {
            abort(403, 'You do not have permission to create blog posts.');
        }

        $categories = Category::active()->get();
        $tags       = Tag::active()->get();

        return view('admin.blogs.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created blog
     */
    public function store(Request $request)
    {
        if (! Auth::user()->canCreateBlog()) {
            abort(403, 'You do not have permission to create blog posts.');
        }

        $request->validate([
            'title'             => 'required|string|max:255',
            'content'           => 'required|string',
            'excerpt'           => 'nullable|string|max:500',
            'short_description' => 'nullable|string|max:255',
            'description'       => 'nullable|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'            => 'required|in:draft,published',
            'categories'        => 'required|array|min:1',
            'categories.*'      => 'exists:categories,id',
            'tags'              => 'nullable|array',
            'tags.*'            => 'exists:tags,id',
        ]);

        $blog                    = new Blog();
        $blog->title             = $request->input('title');
        $blog->slug              = $this->generateUniqueSlug($request->input('title'));
        $blog->content           = $request->input('content');
        $blog->excerpt           = $request->input('excerpt');
        $blog->short_description = $request->input('short_description');
        $blog->description       = $request->input('description');
        $blog->status            = $request->input('status');
        $blog->user_id           = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath   = $request->file('image')->store('blog/images', 'public');
            $blog->image = $imagePath;
        }

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath   = $request->file('thumbnail')->store('blog/thumbnails', 'public');
            $blog->thumbnail = $thumbnailPath;
        }

        $blog->save();

        // Attach categories and tags
        $blog->categories()->attach($request->categories);
        if ($request->filled('tags')) {
            $blog->tags()->attach($request->tags);
        }

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Show the form for editing the specified blog
     */
    public function edit(Blog $blog)
    {
        if (! Auth::user()->isAdmin() && $blog->user_id !== Auth::id()) {
            abort(403, 'You can only edit your own blog posts.');
        }

        $categories = Category::active()->get();
        $tags       = Tag::active()->get();

        return view('admin.blogs.edit', compact('blog', 'categories', 'tags'));
    }

    /**
     * Update the specified blog
     */
    public function update(Request $request, Blog $blog)
    {
        if (! Auth::user()->isAdmin() && $blog->user_id !== Auth::id()) {
            abort(403, 'You can only edit your own blog posts.');
        }

        try {
            $request->validate([
                'title'             => 'required|string|max:255',
                'content'           => 'required|string',
                'excerpt'           => 'nullable|string|max:500',
                'short_description' => 'nullable|string|max:255',
                'description'       => 'nullable|string',
                'image'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
                'thumbnail'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB
                'status'            => 'required|in:draft,published',
                'categories'        => 'required|array|min:1',
                'categories.*'      => 'exists:categories,id',
                'tags'              => 'nullable|array',
                'tags.*'            => 'exists:tags,id',
            ]);

            $blog->title = $request->input('title');
            $blog->slug  = $blog->title !== $request->input('title')
            ? $this->generateUniqueSlug($request->input('title'), $blog->id)
            : $blog->slug;
            $blog->content           = $request->input('content');
            $blog->excerpt           = $request->input('excerpt');
            $blog->short_description = $request->input('short_description');
            $blog->description       = $request->input('description');
            $blog->status            = $request->input('status');

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if it's not a default image
                if ($blog->image && ! str_starts_with($blog->image, 'defaults_images/')) {
                    Storage::disk('public')->delete($blog->image);
                }

                $imagePath   = $request->file('image')->store('blog/images', 'public');
                $blog->image = $imagePath;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if it's not a default image
                if ($blog->thumbnail && ! str_starts_with($blog->thumbnail, 'defaults_images/')) {
                    Storage::disk('public')->delete($blog->thumbnail);
                }

                $thumbnailPath   = $request->file('thumbnail')->store('blog/thumbnails', 'public');
                $blog->thumbnail = $thumbnailPath;
            }

            $blog->save();

            // Update categories and tags
            $blog->categories()->sync($request->categories);
            $blog->tags()->sync($request->filled('tags') ? $request->tags : []);

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog post updated successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'An error occurred while updating the blog: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified blog
     */
    public function destroy(Blog $blog)
    {
        if (! Auth::user()->isAdmin() && $blog->user_id !== Auth::id()) {
            abort(403, 'You can only delete your own blog posts.');
        }

        // Delete thumbnail
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Toggle blog status
     */
    public function toggleStatus(Blog $blog)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can toggle blog status.');
        }

        $newStatus = $blog->status === 'published' ? 'draft' : 'published';
        $blog->update(['status' => $newStatus]);

        return redirect()->back()->with('success', "Blog post moved to {$newStatus}!");
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can perform bulk actions.');
        }

        $request->validate([
            'action'  => 'required|in:publish,draft,delete',
            'blogs'   => 'required|array|min:1',
            'blogs.*' => 'exists:blogs,id',
        ]);

        $blogs = Blog::whereIn('id', $request->blogs);

        switch ($request->action) {
            case 'publish':
                $blogs->update(['status' => 'published']);
                $message = 'Blog posts published successfully!';
                break;

            case 'draft':
                $blogs->update(['status' => 'draft']);
                $message = 'Blog posts moved to draft successfully!';
                break;

            case 'delete':
                $blogs->each(function ($blog) {
                    if ($blog->thumbnail) {
                        Storage::disk('public')->delete($blog->thumbnail);
                    }
                });
                $blogs->delete();
                $message = 'Blog posts deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get blog statistics
     */
    public function stats()
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can view blog statistics.');
        }

        $stats = [
            'total'           => Blog::count(),
            'published'       => Blog::where('status', 'published')->count(),
            'draft'           => Blog::where('status', 'draft')->count(),
            'total_views'     => Blog::sum('views'),
            'total_comments'  => \App\Models\Comment::count(),
            'total_likes'     => \App\Models\Like::where('likeable_type', Blog::class)->count(),
            'total_bookmarks' => \App\Models\Bookmark::count(),
            'today'           => Blog::whereDate('created_at', today())->count(),
            'this_week'       => Blog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month'      => Blog::whereMonth('created_at', now()->month)->count(),
        ];

        // Top blogs by views
        $topBlogsByViews = Blog::orderBy('views', 'desc')->take(10)->get();

        // Top blogs by comments
        $topBlogsByComments = Blog::withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();

        // Top blogs by likes
        $topBlogsByLikes = Blog::withCount('likes')
            ->orderBy('likes_count', 'desc')
            ->take(10)
            ->get();

        // Recent blogs
        $recentBlogs = Blog::with('user')->latest()->take(10)->get();

        return view('admin.blogs.stats', compact(
            'stats',
            'topBlogsByViews',
            'topBlogsByComments',
            'topBlogsByLikes',
            'recentBlogs'
        ));
    }

    /**
     * Generate unique slug
     */
    private function generateUniqueSlug($title, $ignoreId = null)
    {
        $slug         = Str::slug($title);
        $originalSlug = $slug;
        $counter      = 1;

        while (Blog::where('slug', $slug)->when($ignoreId, function ($query, $ignoreId) {
            return $query->where('id', '!=', $ignoreId);
        })->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Duplicate blog post
     */
    public function duplicate(Blog $blog)
    {
        if (! Auth::user()->canCreateBlog()) {
            abort(403, 'You do not have permission to create blog posts.');
        }

        $newBlog          = $blog->replicate();
        $newBlog->title   = $blog->title . ' (Copy)';
        $newBlog->slug    = $this->generateUniqueSlug($newBlog->title);
        $newBlog->status  = 'draft';
        $newBlog->views   = 0;
        $newBlog->user_id = Auth::id();
        $newBlog->save();

        // Copy relationships
        $newBlog->categories()->attach($blog->categories->pluck('id'));
        $newBlog->tags()->attach($blog->tags->pluck('id'));

        return redirect()->route('admin.blogs.edit', $newBlog)
            ->with('success', 'Blog post duplicated successfully!');
    }
}
