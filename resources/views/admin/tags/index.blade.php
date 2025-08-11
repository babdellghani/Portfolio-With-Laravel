@extends('admin.partials.master')

@section('title', 'Manage Tags')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manage Tags</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Tags</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Create Tag -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Quick Create Tag</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.tags.store') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-4">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name"
                                    placeholder="Tag name..." value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="mdi mdi-plus me-1"></i> Add Tag
                                </button>
                            </div>
                        </form>
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
                                    <form method="GET" action="{{ route('admin.tags.index') }}">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control"
                                                placeholder="Search tags..." value="{{ request('search') }}">
                                            <i class="bx bx-search-alt search-icon"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="GET" action="{{ route('admin.tags.index') }}" class="row g-3">
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
                                        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
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

        <!-- Tags Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Bulk Actions -->
                        <form id="bulk-action-form" method="POST" action="{{ route('admin.tags.bulk-action') }}">
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
                                            <th class="align-middle">Tag Name</th>
                                            <th class="align-middle">Slug</th>
                                            <th class="align-middle">Blogs Count</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Created By</th>
                                            <th class="align-middle">Created</th>
                                            <th class="align-middle">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tags as $tag)
                                            <tr>
                                                <td>
                                                    <div class="form-check font-size-16">
                                                        <input class="form-check-input" type="checkbox" name="tags[]"
                                                            value="{{ $tag->id }}">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-3">
                                                            <div class="avatar-xs">
                                                                <span
                                                                    class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                    <i class="ri-price-tag-3-line"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="mb-0">
                                                                <a href="{{ route('admin.tags.show', $tag) }}"
                                                                    class="text-dark">
                                                                    {{ $tag->name }}
                                                                </a>
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <code>{{ $tag->slug }}</code>
                                                </td>
                                                <td>
                                                    <span class="badge bg-soft-info text-info">
                                                        {{ $tag->blogs_count ?? 0 }} blogs
                                                    </span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="badge badge-pill badge-soft-{{ $tag->status ? 'success' : 'danger' }} font-size-12">
                                                        {{ $tag->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>{{ $tag->user->name }}</td>
                                                <td>{{ $tag->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-3">
                                                        <a href="{{ route('admin.tags.show', $tag) }}" class="text-success">
                                                            <i class="mdi mdi-eye font-size-18"></i>
                                                        </a>
                                                        <a href="{{ route('admin.tags.edit', $tag) }}" class="text-success">
                                                            <i class="mdi mdi-pencil font-size-18"></i>
                                                        </a>
                                                        <button type="submit" form="toggle-status-form-{{ $tag->id }}" class="btn btn-link text-warning p-0">
                                                            <i class="mdi mdi-{{ $tag->status ? 'eye-off' : 'eye' }} font-size-18"></i>
                                                        </button>
                                                        <button type="submit" form="delete-form-{{ $tag->id }}" class="btn btn-link text-danger p-0"
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
                                                        <i class="ri-price-tag-line font-size-48 d-block mb-3"></i>
                                                        <h5>No tags found</h5>
                                                        <p>Create your first tag to categorize your blog posts.</p>
                                                        <a href="{{ route('admin.tags.create') }}"
                                                            class="btn btn-primary">Create Tag</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        @foreach($tags as $tag)
                            <form action="{{ route('admin.tags.toggle-status', $tag) }}" method="POST"
                                id="toggle-status-form-{{ $tag->id }}" style="display: none;">
                                @csrf
                                @method('PATCH')
                            </form>
                            <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" id="delete-form-{{ $tag->id }}"
                                style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endforeach

                        <!-- Pagination -->
                        @if($tags->hasPages())
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <div class="text-muted">
                                            Showing {{ $tags->firstItem() }} to {{ $tags->lastItem() }} of {{ $tags->total() }}
                                            results
                                        </div>
                                        <nav aria-label="Page navigation">
                                            {{ $tags->appends(request()->query())->links('pagination::bootstrap-4') }}
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
                const checkboxes = document.querySelectorAll('input[name="tags[]"]');
                checkboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
            });

            // Bulk action form validation
            document.getElementById('bulk-action-form').addEventListener('submit', function (e) {
                const selectedTags = document.querySelectorAll('input[name="tags[]"]:checked');
                const action = document.querySelector('select[name="action"]').value;

                if (selectedTags.length === 0) {
                    e.preventDefault();
                    alert('Please select at least one tag.');
                    return;
                }

                if (!action) {
                    e.preventDefault();
                    alert('Please select an action.');
                    return;
                }

                if (action === 'delete') {
                    if (!confirm('Are you sure you want to delete the selected tags? This may affect related blog posts.')) {
                        e.preventDefault();
                    }
                }
            });
        });
    </script>
@endsection