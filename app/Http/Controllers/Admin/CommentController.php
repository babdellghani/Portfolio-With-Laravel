<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of comments
     */
    public function index(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can manage comments.');
        }

        $query = Comment::with(['user', 'blog', 'parent'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->where('status', true);
            } elseif ($request->status === 'pending') {
                $query->where('status', false);
            }
        }

        // Filter by blog
        if ($request->filled('blog_id')) {
            $query->where('blog_id', $request->blog_id);
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('content', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($userQuery) use ($searchTerm) {
                        $userQuery->where('name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('blog', function ($blogQuery) use ($searchTerm) {
                        $blogQuery->where('title', 'like', "%{$searchTerm}%");
                    });
            });
        }

        $comments = $query->paginate(20);
        $blogs    = Blog::select('id', 'title')->get();

        return view('admin.comments.index', compact('comments', 'blogs'));
    }

    /**
     * Display the specified comment
     */
    public function show(Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can view comment details.');
        }

        $comment->load(['user', 'blog', 'parent', 'replies.user', 'likes.user']);
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified comment
     */
    public function edit(Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can edit comments.');
        }

        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment
     */
    public function update(Request $request, Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can update comments.');
        }

        $request->validate([
            'content' => 'required|string|max:1000',
            'status'  => 'boolean',
        ]);

        $comment->update([
            'content' => $request->input('content'),
            'status'  => $request->boolean('status', false),
        ]);

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified comment
     */
    public function destroy(Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can delete comments.');
        }

        // Delete all replies first
        $comment->replies()->delete();

        // Delete the comment
        $comment->delete();

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment and all its replies deleted successfully!');
    }

    /**
     * Toggle comment status
     */
    public function toggleStatus(Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can toggle comment status.');
        }

        $comment->update([
            'status' => ! $comment->status,
        ]);

        $status = $comment->status ? 'approved' : 'pending';
        return redirect()->back()->with('success', "Comment marked as {$status}!");
    }

    /**
     * Approve comment
     */
    public function approve(Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can approve comments.');
        }

        $comment->update(['status' => true]);

        return redirect()->back()->with('success', 'Comment approved successfully!');
    }

    /**
     * Reject/Hide comment
     */
    public function reject(Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can reject comments.');
        }

        $comment->update(['status' => false]);

        return redirect()->back()->with('success', 'Comment rejected successfully!');
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
            'action'     => 'required|in:approve,reject,delete',
            'comments'   => 'required|array|min:1',
            'comments.*' => 'exists:comments,id',
        ]);

        $comments = Comment::whereIn('id', $request->comments);

        switch ($request->action) {
            case 'approve':
                $comments->update(['status' => true]);
                $message = 'Comments approved successfully!';
                break;

            case 'reject':
                $comments->update(['status' => false]);
                $message = 'Comments rejected successfully!';
                break;

            case 'delete':
                // Get all comment IDs including replies
                $commentIds    = $comments->pluck('id')->toArray();
                $allCommentIds = Comment::whereIn('parent_id', $commentIds)
                    ->pluck('id')
                    ->merge($commentIds)
                    ->unique()
                    ->toArray();

                Comment::whereIn('id', $allCommentIds)->delete();
                $message = 'Comments and their replies deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    
}