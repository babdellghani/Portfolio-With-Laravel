<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
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
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can manage tags.');
        }

        $query = Tag::with(['user'])
            ->withBlogCount()
            ->latest();

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
     * Show the form for creating a new tag
     */
    public function create()
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can create tags.');
        }

        return view('admin.tags.create');
    }

    /**
     * Store a newly created tag
     */
    public function store(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can create tags.');
        }

        $request->validate([
            'name'   => 'required|string|max:255|unique:tags,name',
            'status' => 'boolean',
        ]);

        Tag::create([
            'name'    => $request->input('name'),
            'slug'    => Str::slug($request->input('name')),
            'status'  => $request->boolean('status', true),
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag created successfully!');
    }

    /**
     * Display the specified tag
     */
    public function show(Tag $tag)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can view tag details.');
        }

        $tag->load(['user', 'blogs.user']);
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified tag
     */
    public function edit(Tag $tag)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can edit tags.');
        }

        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified tag
     */
    public function update(Request $request, Tag $tag)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can update tags.');
        }

        $request->validate([
            'name'   => 'required|string|max:255|unique:tags,name,' . $tag->id,
            'status' => 'boolean',
        ]);

        $tag->update([
            'name'   => $request->input('name'),
            'slug'   => Str::slug($request->input('name')),
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.tags.index')
            ->with('success', 'Tag updated successfully!');
    }

    /**
     * Remove the specified tag
     */
    public function destroy(Tag $tag)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can delete tags.');
        }

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
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can toggle tag status.');
        }

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
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can perform bulk actions.');
        }

        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'tags'   => 'required|array|min:1',
            'tags.*' => 'exists:tags,id',
        ]);

        $tags = Tag::whereIn('id', $request->tags);

        switch ($request->action) {
            case 'activate':
                $tags->update(['status' => true]);
                $message = 'Tags activated successfully!';
                break;

            case 'deactivate':
                $tags->update(['status' => false]);
                $message = 'Tags deactivated successfully!';
                break;

            case 'delete':
                // Check if any tag has blogs
                $tagsWithBlogs = $tags->whereHas('blogs')->count();
                if ($tagsWithBlogs > 0) {
                    return redirect()->back()
                        ->with('error', 'Cannot delete tags that have associated blog posts.');
                }

                $tags->delete();
                $message = 'Tags deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Get tags for AJAX requests
     */
    public function search(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403);
        }

        $tags = Tag::active()
            ->where('name', 'like', '%' . $request->q . '%')
            ->limit(20)
            ->get(['id', 'name']);

        return response()->json($tags);
    }
}
