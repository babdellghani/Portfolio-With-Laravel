<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use App\Notifications\NewTagCreated;
use App\Notifications\TagUpdated;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TagController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of tags
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Tag::class);

        // Mark tag-related notifications as read when visiting this page
        $this->markTagNotificationsAsRead();

        if (Auth::user()->isAdmin()) {
            $query = Tag::with(['user'])
                ->withBlogCount()
                ->latest();
        } else {
            $query = Tag::with(['user'])
                ->withBlogCount()
                ->where('user_id', Auth::id())
                ->latest();
        }

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }

        $tags = $query->paginate(20);

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Store a newly created tag
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tag::class);

        $request->validate([
            'name'   => 'required|string|max:255|unique:tags,name',
            'status' => 'boolean',
        ]);

        $tag = Tag::create([
            'name'    => $request->input('name'),
            'slug'    => Str::slug($request->input('name')),
            'status'  => Auth::user()->isAdmin() ? $request->boolean('status', true) : false,
            'user_id' => Auth::id(),
        ]);

        // Notify admin users about new tag (only if not created by admin)
        if (!Auth::user()->isAdmin()) {
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new NewTagCreated($tag, Auth::user()));
            }
        }

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully!');
    }

    /**
     * Show the form for editing the specified tag
     */
    public function edit(Tag $tag)
    {
        $this->authorize('view', $tag);

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag
     */
    public function update(Request $request, Tag $tag)
    {
        $this->authorize('update', $tag);

        $request->validate([
            'name'   => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'status' => 'boolean',
        ]);

        $tag->update([
            'name'   => $request->input('name'),
            'slug'   => Str::slug($request->input('name')),
            'status' => Auth::user()->isAdmin() ? $request->boolean('status', true) : false,
        ]);

        // Notify admin users about tag update (only if not updated by admin)
        if (!Auth::user()->isAdmin()) {
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new TagUpdated($tag, Auth::user()));
            }
        }

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag
     */
    public function destroy(Tag $tag)
    {
        $this->authorize('delete', $tag);

        // Check if tag has blogs
        if ($tag->blogs()->count() > 0) {
            return redirect()->route('admin.tags.index')
                ->with('error', 'Cannot delete tag that has associated blog posts.');
        }

        $tag->delete();

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully!');
    }

    /**
     * Toggle tag status
     */
    public function toggleStatus(Tag $tag)
    {
        $this->authorize('admin', Tag::class);

        $tag->update([
            'status' => ! $tag->status,
        ]);

        $status = $tag->status ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Tag {$status} successfully!");
    }

    /**
     * Bulk actions
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'tags'   => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
        ]);

        $tags = Tag::whereIn('id', $request->tags);

        switch ($request->action) {
            case 'activate':
                $this->authorize('admin', Tag::class);

                $tags->update(['status' => true]);
                $message = 'Tags activated successfully!';
                break;

            case 'deactivate':
                $this->authorize('admin', Tag::class);

                $tags->update(['status' => false]);
                $message = 'Tags deactivated successfully!';
                break;

            case 'delete':
                $tagsToDelete = $tags->get();

                // Check if any tag has blogs
                $tagsWithBlogs = $tagsToDelete->filter(function ($tag) {
                    return $tag->blogs()->count() > 0;
                });

                if ($tagsWithBlogs->count() > 0) {
                    return redirect()->back()
                        ->with('error', 'Cannot delete tags that have associated blog posts.');
                }

                $tagsToDelete->each(function ($tag) {
                    $this->authorize('delete', $tag);
                    // Delete the tag
                    $tag->delete();
                });

                $message = 'Tags deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Mark tag-related notifications as read
     */
    private function markTagNotificationsAsRead()
    {
        // Mark tag-related notifications as read for the current user
        Auth::user()->unreadNotifications()
            ->whereIn('type', [
                'App\Notifications\NewTagCreated',
                'App\Notifications\TagUpdated'
            ])
            ->update(['read_at' => now()]);
    }
}
