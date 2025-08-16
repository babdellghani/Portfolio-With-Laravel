<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Like;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of all likes (Admin only)
     */
    public function index(Request $request)
    {
        $query = Like::where('user_id', Auth::id())->with(['likeable']);

        // Filter by likeable type
        if ($request->has('likeable_type') && !empty($request->likeable_type)) {
            $query->where('likeable_type', $request->likeable_type);
        }

        // Filter by date range
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $likes = $query->paginate(20)->withQueryString();

        // Get statistics
        $stats = [
            'total_likes' => Like::where('user_id', Auth::id())->count(),
            'blog_likes' => Like::where('user_id', Auth::id())->where('likeable_type', 'App\Models\Blog')->count(),
            'comment_likes' => Like::where('user_id', Auth::id())->where('likeable_type', 'App\Models\Comment')->count(),
        ];

        // Get likeable types for filter
        $likeableTypes = [
            'App\Models\Blog' => 'Blog Posts',
            'App\Models\Comment' => 'Comments'
        ];

        return view('admin.likes.index', compact('likes', 'stats', 'likeableTypes'));
    }

    /**
     * Toggle like for a blog post
     */
    public function toggleBlog(Blog $blog)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $like   = Like::where('user_id', $userId)
            ->where('likeable_type', Blog::class)
            ->where('likeable_id', $blog->id)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id'       => $userId,
                'likeable_type' => Blog::class,
                'likeable_id'   => $blog->id,
            ]);
            $liked = true;
        }

        return redirect()->back()->with('success', 'Blog ' . ($liked ? 'liked' : 'unliked') . ' successfully!');
    }

    /**
     * Toggle like for a comment
     */
    public function toggleComment(Comment $comment)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $like   = Like::where('user_id', $userId)
            ->where('likeable_type', Comment::class)
            ->where('likeable_id', $comment->id)
            ->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id'       => $userId,
                'likeable_type' => Comment::class,
                'likeable_id'   => $comment->id,
            ]);
            $liked = true;
        }

        return redirect()->back()->with('success', 'Comment ' . ($liked ? 'liked' : 'unliked') . ' successfully!');
    }

    /**
     * Remove like (Admin only)
     */
    public function destroy(Like $like)
    {
        if (! Auth::user() || Auth::id() !== $like->user_id) {
            return redirect()->route('login');
        }

        $like->delete();

        return redirect()->back()->with('success', 'Like removed successfully!');
    }

    /**
     * Bulk action for likes (Admin only)
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'like_ids' => 'required|array',
            'like_ids.*' => 'exists:likes,id'
        ]);

        $count = 0;

        if ($request->action === 'delete') {
            $likes = Like::whereIn('id', $request->like_ids)->get();
            
            foreach ($likes as $like) {
            if (! Auth::user() || Auth::id() !== $like->user_id) {
                return redirect()->route('login');
            }
            }
            
            $count = $likes->count();
            Like::whereIn('id', $request->like_ids)->delete();
        }

        return redirect()->back()->with('success', "Successfully processed {$count} likes!");
    }
}