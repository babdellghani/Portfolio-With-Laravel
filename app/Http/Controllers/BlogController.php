<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class BlogController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of blogs
     */
    public function index(Request $request)
    {
        $query = Blog::with(['user', 'likes', 'bookmarks'])
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

        $blogs       = $query->paginate(19);
        dd($blogs);
        $recentBlogs = Blog::latest()->published()->take(5)->get();
        $categories  = Category::whereHas('blogs')->active()->get();
        $tags        = Tag::whereHas('blogs', function ($q) {
            $q->published();
        })->active()->withCount('blogs')->orderBy('blogs_count', 'desc')->take(10)->get();
        $comments    = Comment::active()->latest()->take(5)->get();

        return view('frontend.pages.blog', compact('blogs', 'categories', 'tags', 'comments', 'recentBlogs'));
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

        return view('frontend.pages.blog_details', compact('blog', 'relatedPosts', 'userHasLiked', 'userHasBookmarked'));
    }
}