<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Display a listing of all bookmarks (Admin only)
     */
    public function index(Request $request)
    {
        $query = Bookmark::where('user_id', Auth::id());


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

        $bookmarks = $query->paginate(20)->withQueryString();

        // Get statistics
        $stats = [
            'total_bookmarks' => Bookmark::where('user_id', Auth::id())->count(),
        ];

        return view('admin.bookmarks.index', compact('bookmarks', 'stats'));
    }

    /**
     * Toggle bookmark for a blog post
     */
    public function toggle(Blog $blog)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $userId   = Auth::id();
        $bookmark = Bookmark::where('user_id', $userId)
            ->where('blog_id', $blog->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            $message    = 'Bookmark removed successfully!';
        } else {
            Bookmark::create([
                'user_id' => $userId,
                'blog_id' => $blog->id,
            ]);
            $message    = 'Blog bookmarked successfully!';
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Remove bookmark
     */
    public function destroy(Bookmark $bookmark)
    {
        if (! Auth::user() || Auth::id() !== $bookmark->user_id) {
            return redirect()->route('login');
        }

        $bookmark->delete();

        return redirect()->back()->with('success', 'Bookmark removed successfully!');
    }

    /**
     * Bulk action for bookmarks (Admin only)
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete',
            'bookmark_ids' => 'required|array',
            'bookmark_ids.*' => 'exists:bookmarks,id'
        ]);

        $count = 0;

        if ($request->action === 'delete') {
            $bookmarksToDelete = Bookmark::whereIn('id', $request->bookmark_ids)->get();
            
            foreach ($bookmarksToDelete as $bookmark) {
            if (! Auth::user() || Auth::id() !== $bookmark->user_id) {
                return redirect()->route('login');
            }
            }
            
            $count = $bookmarksToDelete->count();
            Bookmark::whereIn('id', $request->bookmark_ids)->delete();
        }

        return redirect()->back()->with('success', "Successfully processed {$count} bookmarks!");
    }
}