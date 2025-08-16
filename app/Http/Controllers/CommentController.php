<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Comment;
use App\Models\User;
use App\Notifications\NewCommentCreated;
use App\Notifications\CommentUpdated;
use App\Notifications\CommentReply;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    use AuthorizesRequests;

    /**
     * Store a new comment
     */
    public function store(Request $request, Blog $blog)
    {
        if (! Auth::check()) {
            return redirect()->back()->with('error', 'You must be logged in to comment.');
        }

        if (! Auth::user()->canComment()) {
            return redirect()->back()->with('error', 'Only active users can comment.');
        }

        $request->validate([
            'content'   => 'required|string|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'content'   => $request->input('content'),
            'blog_id'   => $blog->id,
            'user_id'   => Auth::id(),
            'parent_id' => $request->input('parent_id'),
            'status'    => Auth::user()->isAdmin() ? 1 : 0, // Admins can post directly, others are pending
        ]);

        // Check if this is a reply to another comment
        if ($request->input('parent_id')) {
            $parentComment = Comment::find($request->input('parent_id'));

            // Notify the original comment author (if not replying to themselves)
            if ($parentComment && $parentComment->user_id !== Auth::id()) {
                $parentComment->user->notify(new CommentReply($comment, Auth::user(), $parentComment));
            }
        }

        // Notify admin users about new comment
        if (!Auth::user()->isAdmin()) {
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new NewCommentCreated($comment, Auth::user()));
            }
        }

        return redirect()->back()->with('success', 'Comment added successfully!');
    }

    /**
     * Update a comment
     */
    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        $comment->update([
            'content' => $request->input('content'),
            'status'  => Auth::user()->isAdmin() ? 1 : 0, // Ensure status is set correctly
        ]);

        // Notify admin users about comment update
        if (!Auth::user()->isAdmin()) {
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new CommentUpdated($comment, Auth::user()));
            }
        }

        return redirect()->back()->with('success', 'Comment updated successfully!');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return redirect()->back()->with('success', 'Comment deleted successfully!');
    }

    /**
     * Toggle comment status (admin only)
     */
    public function toggleStatus(Comment $comment)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $comment->update([
            'status' => ! $comment->status,
        ]);

        $status = $comment->status ? 'approved' : 'hidden';
        return redirect()->back()->with('success', "Comment {$status} successfully!");
    }
}
