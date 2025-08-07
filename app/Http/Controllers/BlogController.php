<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of blogs
     */
    public function index(Request $request)
    {
        $query = Blog::with(['user', 'categories', 'tags'])
            ->published()
            ->latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
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

        $blogs      = $query->paginate(9);
        $categories = Category::active()->get();
        $tags       = Tag::active()->get();

        return view('frontend.blog.index', compact('blogs', 'categories', 'tags'));
    }

    /**
     * Display the specified blog post
     */
    public function show($slug)
    {
        $blog = Blog::with(['user', 'categories', 'tags', 'comments.user', 'comments.replies.user'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        // Increment view count
        $blog->increment('views');

        // Get related posts
        $relatedPosts = Blog::with(['user', 'categories'])
            ->whereHas('categories', function ($query) use ($blog) {
                $query->whereIn('categories.id', $blog->categories->pluck('id'));
            })
            ->where('id', '!=', $blog->id)
            ->published()
            ->latest()
            ->take(3)
            ->get();

        // Check if user has liked and bookmarked this post
        $userHasLiked      = false;
        $userHasBookmarked = false;

        if (Auth::check()) {
            $userHasLiked      = $blog->isLikedByUser(Auth::id());
            $userHasBookmarked = $blog->isBookmarkedByUser(Auth::id());
        }

        return view('frontend.blog.show', compact('blog', 'relatedPosts', 'userHasLiked', 'userHasBookmarked'));
    }

    /**
     * Show form for creating a new blog post (admin only)
     */
    public function create()
    {
        $this->authorize('create', Blog::class);

        $categories = Category::active()->get();
        $tags       = Tag::active()->get();

        return view('admin.blog.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created blog post
     */
    public function store(Request $request)
    {
        $this->authorize('create', Blog::class);

        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'excerpt'      => 'nullable|string|max:500',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'       => 'required|in:draft,published',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        $blog          = new Blog();
        $blog->title   = $request->input('title');
        $blog->slug    = Str::slug($request->input('title'));
        $blog->content = $request->input('content');
        $blog->excerpt = $request->input('excerpt');
        $blog->status  = $request->input('status');
        $blog->user_id = Auth::id();

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

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post created successfully!');
    }

    /**
     * Show form for editing a blog post
     */
    public function edit(Blog $blog)
    {
        $this->authorize('update', $blog);

        $categories = Category::active()->get();
        $tags       = Tag::active()->get();

        return view('admin.blog.edit', compact('blog', 'categories', 'tags'));
    }

    /**
     * Update the specified blog post
     */
    public function update(Request $request, Blog $blog)
    {
        $this->authorize('update', $blog);

        $request->validate([
            'title'        => 'required|string|max:255',
            'content'      => 'required|string',
            'excerpt'      => 'nullable|string|max:500',
            'thumbnail'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'       => 'required|in:draft,published',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ]);

        $blog->title   = $request->input('title');
        $blog->slug    = Str::slug($request->input('title'));
        $blog->content = $request->input('content');
        $blog->excerpt = $request->input('excerpt');
        $blog->status  = $request->input('status');

        // Handle thumbnail upload
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($blog->thumbnail) {
                Storage::disk('public')->delete($blog->thumbnail);
            }

            $thumbnailPath   = $request->file('thumbnail')->store('blog/thumbnails', 'public');
            $blog->thumbnail = $thumbnailPath;
        }

        $blog->save();

        // Update categories and tags
        $blog->categories()->sync($request->categories);
        $blog->tags()->sync($request->filled('tags') ? $request->tags : []);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post
     */
    public function destroy(Blog $blog)
    {
        $this->authorize('delete', $blog);

        // Delete thumbnail
        if ($blog->thumbnail) {
            Storage::disk('public')->delete($blog->thumbnail);
        }

        $blog->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Display blog posts for admin
     */
    public function adminIndex()
    {
        $this->authorize('viewAny', Blog::class);

        $blogs = Blog::with(['user', 'categories', 'tags'])
            ->latest()
            ->paginate(15);

        return view('admin.blog.index', compact('blogs'));
    }
}
