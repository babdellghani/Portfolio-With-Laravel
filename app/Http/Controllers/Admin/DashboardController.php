<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can access the dashboard.');
        }

        // General statistics
        $stats = [
            'users'        => [
                'total'          => User::count(),
                'active'         => User::where('status', 'active')->count(),
                'admins'         => User::where('role', 'admin')->count(),
                'new_this_month' => User::whereMonth('created_at', now()->month)->count(),
            ],
            'blogs'        => [
                'total'          => Blog::count(),
                'published'      => Blog::where('status', 'published')->count(),
                'draft'          => Blog::where('status', 'draft')->count(),
                'total_views'    => Blog::sum('views'),
                'new_this_month' => Blog::whereMonth('created_at', now()->month)->count(),
            ],
            'comments'     => [
                'total'     => Comment::count(),
                'approved'  => Comment::where('status', true)->count(),
                'pending'   => Comment::where('status', false)->count(),
                'new_today' => Comment::whereDate('created_at', today())->count(),
            ],
            'interactions' => [
                'total_likes'     => Like::count(),
                'blog_likes'      => Like::where('likeable_type', Blog::class)->count(),
                'comment_likes'   => Like::where('likeable_type', Comment::class)->count(),
                'total_bookmarks' => Bookmark::count(),
            ],
            'content'      => [
                'categories'        => Category::count(),
                'active_categories' => Category::where('status', true)->count(),
                'tags'              => Tag::count(),
                'active_tags'       => Tag::where('status', true)->count(),
            ],
        ];

        // Recent activities
        $recentBlogs = Blog::with('user')
            ->latest()
            ->take(5)
            ->get();

        $recentComments = Comment::with(['user', 'blog'])
            ->latest()
            ->take(5)
            ->get();

        $recentUsers = User::latest()
            ->take(5)
            ->get();

        // Top performing content
        $topBlogsByViews = Blog::with('user')
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        $topBlogsByComments = Blog::with('user')
            ->withCount('comments')
            ->orderBy('comments_count', 'desc')
            ->take(5)
            ->get();

        // Monthly blog creation chart data
        $monthlyBlogData = Blog::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as count')
        )
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // Fill missing months with 0
        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $monthlyBlogData[$i] ?? 0;
        }

        // Comments vs Blogs ratio
        $commentsVsBlogsData = Blog::select(
            'id',
            'title',
            DB::raw('(SELECT COUNT(*) FROM comments WHERE blog_id = blogs.id) as comments_count')
        )
            ->having('comments_count', '>', 0)
            ->orderBy('comments_count', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentBlogs',
            'recentComments',
            'recentUsers',
            'topBlogsByViews',
            'topBlogsByComments',
            'chartData',
            'commentsVsBlogsData'
        ));
    }
}
