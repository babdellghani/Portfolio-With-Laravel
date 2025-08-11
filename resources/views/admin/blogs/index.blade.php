@extends('admin.partials.master')

@section('title', 'Manage Blogs')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manage Blogs</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Blogs</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters and Actions -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-4">
                                <div class="search-box me-2 mb-2 d-inline-block">
                                    <form method="GET" action="{{ route('admin.blogs.index') }}">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search blogs..." value="{{ request('search') }}">
                                            <i class="bx bx-search-alt search-icon"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.blogs.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> New Blog
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="GET" action="{{ route('admin.blogs.index') }}" class="row g-3">
                                    <div class="col-lg-3">
                                        <select name="status" class="form-select">
                                            <option value="">All Status</option>
                                            <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>
                                                Draft</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select name="category_id" class="form-select">
                                            <option value="">All Categories</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select name="author_id" class="form-select">
                                            <option value="">All Authors</option>
                                            @foreach($authors as $author)
                                                <option value="{{ $author->id }}" {{ request('author_id') == $author->id ? 'selected' : '' }}>
                                                    {{ $author->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-filter-alt me-1"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                                            <i class="bx bx-revision me-1"></i> Reset
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Blogs Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Bulk Actions -->
                        <form id="bulk-action-form" method="POST" action="{{ route('admin.blogs.bulk-action') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center">
                                        <select name="action" class="form-select me-2" style="width: auto;" required>
                                            <option value="">Bulk Actions</option>
                                            <option value="publish">Publish</option>
                                            <option value="draft">Move to Draft</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button type="submit" class="btn btn-secondary btn-sm">Apply</button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table align-middle table-nowrap table-check">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20px;" class="align-middle">
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" id="checkAll">
                                                    <label class="form-check-label" for="checkAll"></label>
                                                </div>
                                            </th>
                                            <th class="align-middle">Title</th>
                                            <th class="align-middle">Author</th>
                                            <th class="align-middle">Categories</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Stats</th>
                                            <th class="align-middle">Created</th>
                                            <th class="align-middle">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($blogs as $blog)
                                            <tr>
                                                <td>
                                                    <div class="form-check font-size-16">
                                                        <input class="form-check-input" type="checkbox" name="blogs[]"
                                                            value="{{ $blog->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            @if($blog->thumbnail)
                                                                <img src="{{ $blog->thumbnail && str_starts_with($blog->thumbnail, 'defaults_images/') ? asset($blog->thumbnail) : asset('storage/' . $blog->thumbnail) }}"
                                                                    alt="" class="avatar-sm rounded">
                                                            @else
                                                                <div class="avatar-sm">
                                                                    <span class="avatar-title rounded bg-primary">
                                                                        {{ strtoupper(substr($blog->title, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">
                                                                <a href="{{ route('admin.blogs.show', $blog) }}"
                                                                    class="text-dark">
                                                                    {{ Str::limit($blog->title, 50) }}
                                                                </a>
                                                            </h6>
                                                            <p class="text-muted font-size-13 mb-0">
                                                                {{ Str::limit($blog->excerpt, 80) }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $blog->user->name }}</td>
                                                <td>
                                                    @foreach($blog->categories->take(2) as $category)
                                                        <span
                                                            class="badge bg-soft-primary text-primary">{{ $category->name }}</span>
                                                    @endforeach
                                                    @if($blog->categories->count() > 2)
                                                        <span class="text-muted">+{{ $blog->categories->count() - 2 }}
                                                            more</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill badge-soft-{{ $blog->status === 'published' ? 'success' : 'warning' }} font-size-12">
                                                        {{ ucfirst($blog->status) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="text-muted">
                                                        <i class="ri-eye-line me-1"></i>{{ $blog->views }}
                                                        <i class="ri-chat-3-line me-1 ms-2"></i>{{ $blog->comments_count }}
                                                        <i class="ri-heart-line me-1 ms-2"></i>{{ $blog->likes_count }}
                                                    </div>
                                                </td>
                                                <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-success">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </a>
                                                        <a href="{{ route('blog.show', $blog->slug) }}" target="_blank"
                                                            class="text-info">
                                                            <i class="mdi mdi-open-in-new font-size-18"></i>
                                                        </a>
                                                        <button type="submit" form="duplicate-form-{{ $blog->id }}"
                                                            class="btn btn-link text-warning p-0">
                                                            <i class="mdi mdi-content-copy font-size-18"></i>
                                                        </button>
                                                        <button type="submit" form="delete-form-{{ $blog->id }}"
                                                            class="btn btn-link text-danger p-0"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="mdi mdi-delete font-size-18"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="ri-article-line font-size-48 d-block mb-3"></i>
                                                        <h5>No blogs found</h5>
                                                        <p>Create your first blog post to get started.</p>
                                                        <a href="{{ route('admin.blogs.create') }}"
                                                            class="btn btn-primary">Create Blog</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <!-- Individual Action Forms (Outside bulk form) -->
                        @foreach($blogs as $blog)
                            <form action="{{ route('admin.blogs.duplicate', $blog) }}" method="POST"
                                id="duplicate-form-{{ $blog->id }}" style="display: none;">
                                @csrf
                            </form>
                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                id="delete-form-{{ $blog->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach

                        <!-- Pagination -->
                        @if($blogs->hasPages())
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted">
                                            Showing {{ $blogs->firstItem() }} to {{ $blogs->lastItem() }} of {{ $blogs->total() }} results
                                        </div>
                                        <nav aria-label="Page navigation">
                                            {{ $blogs->appends(request()->query())->links('pagination::bootstrap-4') }}
                                        </nav>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden forms for individual actions -->
    <div id="hidden-forms"></div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Check All functionality
                document.getElementById('checkAll').addEventListener('change', function () {
                    const checkboxes = document.querySelectorAll('input[name="blogs[]"]');
                    checkboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                });

                // Bulk action form validation
                document.getElementById('bulk-action-form').addEventListener('submit', function (e) {
                    const selectedBlogs = document.querySelectorAll('input[name="blogs[]"]:checked');
                    const action = document.querySelector('select[name="action"]').value;

                    if (selectedBlogs.length === 0) {
                        e.preventDefault();
                        alert('Please select at least one blog.');
                        return;
                    }

                    if (!action) {
                        e.preventDefault();
                        alert('Please select an action.');
                        return;
                    }

                    if (action === 'delete') {
                        if (!confirm('Are you sure you want to delete the selected blogs? This action cannot be undone.')) {
                            e.preventDefault();
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection