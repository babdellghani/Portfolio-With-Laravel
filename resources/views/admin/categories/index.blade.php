@extends('admin.partials.master')

@section('title', 'Manage Categories')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manage Categories</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Categories</li>
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
                                    <form method="GET" action="{{ route('admin.categories.index') }}">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search categories..." value="{{ request('search') }}">
                                            <i class="bx bx-search-alt search-icon"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.categories.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-plus me-1"></i> New Category
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="GET" action="{{ route('admin.categories.index') }}" class="row g-3">
                                    <div class="col-lg-3">
                                        <select name="status" class="form-select">
                                            <option value="">All Status</option>
                                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>
                                                Inactive</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-filter-alt me-1"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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

        <!-- Categories Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Bulk Actions -->
                        <form id="bulk-action-form" method="POST" action="{{ route('admin.categories.bulk-action') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center">
                                        <select name="action" class="form-select me-2" style="width: auto;" required>
                                            <option value="">Bulk Actions</option>
                                            <option value="activate">Activate</option>
                                            <option value="deactivate">Deactivate</option>
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
                                            <th class="align-middle">Category</th>
                                            <th class="align-middle">Description</th>
                                            <th class="align-middle">Blogs Count</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Created By</th>
                                            <th class="align-middle">Created</th>
                                            <th class="align-middle">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $category)
                                            <tr>
                                                <td>
                                                    <div class="form-check font-size-16">
                                                        <input class="form-check-input" type="checkbox" name="categories[]"
                                                            value="{{ $category->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            @if($category->image)
                                                                <img src="{{ asset('storage/' . $category->image) }}" alt=""
                                                                    class="avatar-sm rounded">
                                                            @else
                                                                <div class="avatar-sm">
                                                                    <span class="avatar-title rounded bg-primary">
                                                                        {{ strtoupper(substr($category->name, 0, 1)) }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-1">
                                                                <a href="{{ route('admin.categories.show', $category) }}"
                                                                    class="text-dark">
                                                                    {{ $category->name }}
                                                                </a>
                                                            </h6>
                                                            <p class="text-muted font-size-13 mb-0">{{ $category->slug }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ Str::limit($category->description, 50) }}</td>
                                                <td>
                                                    <span class="badge bg-soft-info text-info">
                                                        {{ $category->blogs_count ?? 0 }} blogs
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill badge-soft-{{ $category->status ? 'success' : 'danger' }} font-size-12">
                                                        {{ $category->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>{{ $category->user->name }}</td>
                                                <td>{{ $category->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                                            class="text-success">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </a>
                                                        <button type="submit" form="toggle-status-form-{{ $category->id }}"
                                                            class="btn btn-link text-warning p-0">
                                                            <i
                                                                class="mdi mdi-{{ $category->status ? 'eye-off' : 'eye' }} font-size-18"></i>
                                                        </button>
                                                        <button type="submit" form="delete-form-{{ $category->id }}"
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
                                                        <i class="ri-folder-line font-size-48 d-block mb-3"></i>
                                                        <h5>No categories found</h5>
                                                        <p>Create your first category to organize your blog posts.</p>
                                                        <a href="{{ route('admin.categories.create') }}"
                                                            class="btn btn-primary">Create Category</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        @foreach($categories as $category)
                            <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST"
                                id="toggle-status-form-{{ $category->id }}" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                id="delete-form-{{ $category->id }}" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach

                        <!-- Pagination -->
                        @if($categories->hasPages())
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted">
                                            Showing {{ $categories->firstItem() }} to {{ $categories->lastItem() }} of {{ $categories->total() }} results
                                        </div>
                                        <nav aria-label="Page navigation">
                                            {{ $categories->appends(request()->query())->links('pagination::bootstrap-4') }}
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

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check All functionality
            document.getElementById('checkAll').addEventListener('change', function () {
                const checkboxes = document.querySelectorAll('input[name="categories[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Bulk action form validation
            document.getElementById('bulk-action-form').addEventListener('submit', function (e) {
                const selectedCategories = document.querySelectorAll('input[name="categories[]"]:checked');
                const action = document.querySelector('select[name="action"]').value;

                if (selectedCategories.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one category.');
                    return;
                }

                if (!action) {
                    e.preventDefault();
                    alert('Please select an action.');
                    return;
                }

                if (action === 'delete') {
                    if (!confirm('Are you sure you want to delete the selected categories? This may affect related blog posts.')) {
                        e.preventDefault();
                    }
                }
            });
        });
    </script>
@endsection