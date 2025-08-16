<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\User;
use App\Notifications\NewCategoryCreated;
use App\Notifications\CategoryUpdated;
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
        $this->authorize('viewAny', Category::class);

        // Mark category-related notifications as read when visiting this page
        $this->markCategoryNotificationsAsRead();

        if (Auth::user()->isAdmin()) {
            $query = Category::with(['user'])
                ->withBlogCount()
                ->latest();
        } else {
            $query = Category::with(['user'])
                ->withBlogCount()
                ->where('user_id', Auth::id())
                ->latest();
        }

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
        $this->authorize('create', Category::class);

        return view('admin.categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $this->authorize('create', Category::class);

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

        if (! Auth::user()->isAdmin()) {
            $category->status = false;
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath       = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        // Notify admin users about new category (only if not created by admin)
        if (!Auth::user()->isAdmin()) {
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new NewCategoryCreated($category, Auth::user()));
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);

        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, Category $category)
    {
        $this->authorize('update', $category);

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

        if (! Auth::user()->isAdmin()) {
            $category->status = false;
        }

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

        // Notify admin users about category update (only if not updated by admin)
        if (!Auth::user()->isAdmin()) {
            $adminUsers = User::where('role', 'admin')->get();
            foreach ($adminUsers as $admin) {
                $admin->notify(new CategoryUpdated($category, Auth::user()));
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    /**
     * Remove the specified category
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

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
        $this->authorize('admin', Category::class);

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
        $request->validate([
            'action'       => 'required|in:activate,deactivate,delete',
            'categories'   => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
        ]);

        $categories = Category::whereIn('id', $request->categories);

        switch ($request->action) {
            case 'activate':
                $this->authorize('admin', Category::class);

                $categories->update(['status' => true]);
                $message = 'Categories activated successfully!';
                break;

            case 'deactivate':
                $this->authorize('admin', Category::class);

                $categories->update(['status' => false]);
                $message = 'Categories deactivated successfully!';
                break;

            case 'delete':
                // Get the actual category models first
                $categoriesToDelete = $categories->get();

                // Check if any category has blogs
                $categoriesWithBlogs = $categoriesToDelete->filter(function ($category) {
                    return $category->blogs()->count() > 0;
                });

                if ($categoriesWithBlogs->count() > 0) {
                    return redirect()->back()
                        ->with('error', 'Cannot delete categories that have associated blog posts.');
                }

                // Delete images for each category
                $categoriesToDelete->each(function ($category) {
                    $this->authorize('delete', $category);

                    if ($category->image) {
                        Storage::disk('public')->delete($category->image);
                    }
                    // Delete the category record
                    $category->delete();
                });

                $message = 'Categories deleted successfully!';
                break;
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Mark category-related notifications as read
     */
    private function markCategoryNotificationsAsRead()
    {
        // Mark category-related notifications as read for the current user
        Auth::user()->unreadNotifications()
            ->whereIn('type', [
                'App\Notifications\NewCategoryCreated',
                'App\Notifications\CategoryUpdated'
            ])
            ->update(['read_at' => now()]);
    }
}
