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
        $this->authorize('viewAny', Comment::class);

        // Mark comment-related notifications as read when visiting this page
        $this->markCommentNotificationsAsRead();

        if (Auth::user()->isAdmin()) {
            $query = Comment::with(['user', 'blog', 'parent'])
                ->latest();
        } else {
            $query = Comment::where('user_id', Auth::id())
                ->with(['user', 'blog', 'parent'])
                ->latest();
        }

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
        $this->authorize('view', $comment);

        $comment->load(['user', 'blog', 'parent', 'replies.user', 'likes.user']);
        return view('admin.comments.show', compact('comment'));
    }

    /**
     * Show the form for editing the specified comment
     */
    public function edit(Comment $comment)
    {
        $this->authorize('view', $comment);

        return view('admin.comments.edit', compact('comment'));
    }

    /**
     * Update the specified comment
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000',
            'status'  => 'boolean',
        ]);

        $comment->update([
            'content' => $request->input('content'),
            'status'  => Auth::user()->isAdmin() ? $request->boolean('status', false) : false,
        ]);

        return redirect()->route('admin.comments.index')
            ->with('success', 'Comment updated successfully!');
    }

    /**
     * Remove the specified comment
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

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
        $this->authorize('admin', Blog::class);

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
        $this->authorize('admin', Blog::class);

        $comment->update(['status' => true]);

        return redirect()->back()->with('success', 'Comment approved successfully!');
    }

    /**
     * Reject/Hide comment
     */
    public function reject(Comment $comment)
    {
        $this->authorize('admin', Blog::class);

        $comment->update(['status' => false]);

        return redirect()->back()->with('success', 'Comment rejected successfully!');
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action'     => 'required|in:approve,reject,delete',
            'comments'   => 'required|array|min:1',
            'comments.*' => 'exists:comments,id',
        ]);

        $comments = Comment::whereIn('id', $request->comments);

        switch ($request->action) {
            case 'approve':
                $this->authorize('admin', Blog::class);

                $comments->update(['status' => true]);
                $message = 'Comments approved successfully!';
                break;

            case 'reject':
                $this->authorize('admin', Blog::class);

                $comments->update(['status' => false]);
                $message = 'Comments rejected successfully!';
                break;

            case 'delete':
                // Get all comment IDs including replies
                $commentIds = $comments->pluck('id')->toArray();

                // Authorize delete permission for each comment
                foreach ($comments->get() as $comment) {
                    $this->authorize('delete', $comment);
                }

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

    /**
     * Mark comment-related notifications as read
     */
    private function markCommentNotificationsAsRead()
    {
        if (Auth::user()->isAdmin()) {
            $user = Auth::user();

            // Mark notifications as read for comment-related types
            $user->unreadNotifications()
                ->whereIn('type', [
                    'App\Notifications\NewCommentCreated',
                    'App\Notifications\CommentUpdated'
                ])
                ->update(['read_at' => now()]);
        }
    }
}
