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
        if (Auth::user()->isAdmin()) {

            // General statistics
            $stats = [
                'users'        => [
                    'total'          => User::count(),
                    'active'         => User::where('status', 'active')->count(),
                ],
                'blogs'        => [
                    'total'          => Blog::count(),
                    'published'      => Blog::where('status', 'published')->count(),
                    'total_views'    => Blog::sum('views'),
                ],
                'comments'     => [
                    'total'     => Comment::count(),
                    'pending'   => Comment::where('status', false)->count(),
                ],
                'interactions' => [
                    'total_likes'     => Like::count(),
                    'total_bookmarks' => Bookmark::count(),
                ],
                'content'      => [
                    'categories'        => Category::count(),
                    'tags'              => Tag::count(),
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

            return view('admin.dashboard', compact(
                'stats',
                'recentBlogs',
                'recentComments',
                'chartData',
            ));
        } else {

            $stats = [
                'blogs'        => [
                    'total'          => Blog::where('user_id', Auth::id())->count(),
                    'published'      => Blog::where('user_id', Auth::id())->where('status', 'published')->count(),
                    'total_views'    => Blog::where('user_id', Auth::id())->sum('views'),
                ],
                'comments'     => [
                    'total'     => Comment::where('user_id', Auth::id())->count(),
                    'pending'   => Comment::where('user_id', Auth::id())->where('status', false)->count(),
                ],
                'interactions' => [
                    'total_likes'     => Like::where('user_id', Auth::id())->count(),
                    'total_bookmarks' => Bookmark::where('user_id', Auth::id())->count(),
                ],
                'content'      => [
                    'categories'        => Category::where('user_id', Auth::id())->count(),
                    'tags'              => Tag::where('user_id', Auth::id())->count(),
                ],
            ];

            // Recent activities
            $recentBlogs = Blog::where('user_id', Auth::id())
                ->latest()
                ->take(5)
                ->get();

            $recentComments = Comment::where('user_id', Auth::id())->with(['blog'])
                ->latest()
                ->take(5)
                ->get();

            // Monthly blog creation chart data for user
            $monthlyBlogData = Blog::where('user_id', Auth::id())
                ->select(
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

            return view('admin.dashboard', compact(
                'stats',
                'recentBlogs',
                'recentComments',
                'chartData'
            ));
        }
    }
}