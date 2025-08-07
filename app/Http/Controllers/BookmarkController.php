<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bookmark;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display user's bookmarks
     */
    public function index()
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $bookmarks = Bookmark::with(['blog.user', 'blog.categories'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('frontend.bookmarks.index', compact('bookmarks'));
    }

    /**
     * Toggle bookmark for a blog post
     */
    public function toggle(Blog $blog)
    {
        if (! Auth::check()) {
            return response()->json(['error' => 'You must be logged in to bookmark.'], 401);
        }

        $userId   = Auth::id();
        $bookmark = Bookmark::where('user_id', $userId)
            ->where('blog_id', $blog->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $bookmarked = false;
            $message    = 'Bookmark removed successfully!';
        } else {
            Bookmark::create([
                'user_id' => $userId,
                'blog_id' => $blog->id,
            ]);
            $bookmarked = true;
            $message    = 'Blog bookmarked successfully!';
        }

        return response()->json([
            'bookmarked' => $bookmarked,
            'message'    => $message,
        ]);
    }

    /**
     * Remove bookmark
     */
    public function destroy(Bookmark $bookmark)
    {
        if ($bookmark->user_id !== Auth::id()) {
            abort(403);
        }

        $bookmark->delete();

        return redirect()->back()->with('success', 'Bookmark removed successfully!');
    }
}
