<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of categories
     */
    public function index(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can manage categories.');
        }

        $query = Category::with(['user'])
            ->withBlogCount()
            ->latest();

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status === 'active');
        }

        $categories = $query->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can create categories.');
        }

        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can create categories.');
        }

        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'      => 'boolean',
        ]);

        $category              = new Category();
        $category->name        = $request->input('name');
        $category->slug        = Str::slug($request->input('name'));
        $category->description = $request->input('description');
        $category->status      = $request->boolean('status', true);
        $category->user_id     = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath       = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Display the specified category
     */
    public function show(Category $category)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can view category details.');
        }

        $category->load(['user', 'blogs.user']);
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can edit categories.');
        }

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can update categories.');
        }

        $request->validate([
            'name'        => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string|max:1000',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status'      => 'boolean',
        ]);

        $category->name        = $request->input('name');
        $category->slug        = Str::slug($request->input('name'));
        $category->description = $request->input('description');
        $category->status      = $request->boolean('status', true);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }

            $imagePath       = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can delete categories.');
        }

        // Check if category has blogs
        if ($category->blogs()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category that has associated blog posts.');
        }

        // Delete image
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(Category $category)
    {
        if (! Auth::user()->isAdmin()) {
            abort(403, 'Only admins can toggle category status.');
        }

        $category->update([
            'status' => ! $category->status,
        ]);

        $status = $category->status ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Category {$status} successfully!");
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
            'action'       => 'required|in:activate,deactivate,delete',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $categories = Category::whereIn('id', $request->categories);

        switch ($request->action) {
            case 'activate':
                $categories->update(['status' => true]);
                $message = 'Categories activated successfully!';
                break;

            case 'deactivate':
                $categories->update(['status' => false]);
                $message = 'Categories deactivated successfully!';
                break;

            case 'delete':
                // Check if any category has blogs
                $categoriesWithBlogs = $categories->whereHas('blogs')->count();
                if ($categoriesWithBlogs > 0) {
                    return redirect()->back()
                        ->with('error', 'Cannot delete categories that have associated blog posts.');
                }

                $categories->each(function ($category) {
                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }
                });
                $categories->delete();
                $message = 'Categories deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }
}
