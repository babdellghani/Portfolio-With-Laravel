<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Toggle like for a blog post
     */
    public function toggleBlog(Blog $blog)
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'You must be logged in to like.'], 401);
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

        $likesCount = $blog->likes()->count();

        return response()->json([
            'liked'       => $liked,
            'likes_count' => $likesCount,
        ]);
    }

    /**
     * Toggle like for a comment
     */
    public function toggleComment(Comment $comment)
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'You must be logged in to like.'], 401);
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

        $likesCount = $comment->likes()->count();

        return response()->json([
            'liked'       => $liked,
            'likes_count' => $likesCount,
        ]);
    }
}
