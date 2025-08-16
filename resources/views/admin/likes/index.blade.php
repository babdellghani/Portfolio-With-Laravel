@extends('admin.partials.master')
@section('title', 'Like Management')

@section('style')
    <!-- Boxicons CSS -->
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .stats-card {
            border-left: 4px solid;
            transition: transform 0.2s;
        }

        .stats-card:hover {
            transform: translateY(-2px);
        }

        .stats-card.primary {
            border-left-color: #007bff;
        }

        .stats-card.success {
            border-left-color: #28a745;
        }

        .stats-card.warning {
            border-left-color: #ffc107;
        }

        .stats-card.info {
            border-left-color: #17a2b8;
        }

        .stats-card.secondary {
            border-left-color: #6c757d;
        }

        .stats-card.danger {
            border-left-color: #dc3545;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Like Management</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Likes</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card stats-card primary">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Total Likes</p>
                                <h4 class="mb-2">{{ number_format($stats['total_likes']) }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-primary rounded-3">
                                    <i class="bx bx-like font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card stats-card secondary">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Blog Likes</p>
                                <h4 class="mb-2">{{ number_format($stats['blog_likes']) }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-secondary rounded-3">
                                    <i class="bx bx-book font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-4 col-sm-6">
                <div class="card stats-card danger">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <p class="text-truncate font-size-14 mb-2">Comment Likes</p>
                                <h4 class="mb-2">{{ number_format($stats['comment_likes']) }}</h4>
                            </div>
                            <div class="avatar-sm">
                                <span class="avatar-title bg-light text-danger rounded-3">
                                    <i class="bx bx-comment font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h4 class="card-title">All Likes</h4>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-danger btn-sm" id="bulkDeleteBtn"
                                    style="display: none;">
                                    <i class="bx bx-trash"></i> Delete Selected
                                </button>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <form method="GET" action="{{ route('admin.likes.index') }}"
                                    class="d-flex gap-2 flex-wrap">
                                    <div class="form-group">
                                        <select name="likeable_type" class="form-control form-control-sm">
                                            <option value="">All Types</option>
                                            @foreach ($likeableTypes as $type => $label)
                                                <option value="{{ $type }}"
                                                    {{ request('likeable_type') == $type ? 'selected' : '' }}>
                                                    {{ $label }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="date_from" class="form-control form-control-sm"
                                            placeholder="From" value="{{ request('date_from') }}">
                                    </div>
                                    <div class="form-group">
                                        <input type="date" name="date_to" class="form-control form-control-sm"
                                            placeholder="To" value="{{ request('date_to') }}">
                                    </div>
                                    <div class="form-group">
                                        <select name="sort_by" class="form-control form-control-sm">
                                            <option value="created_at"
                                                {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Sort by Date
                                            </option>
                                            <option value="likeable_type"
                                                {{ request('sort_by') == 'likeable_type' ? 'selected' : '' }}>Sort by Type
                                            </option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <select name="sort_order" class="form-control form-control-sm">
                                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>
                                                Descending</option>
                                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>
                                                Ascending</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="bx bx-search"></i> Filter
                                    </button>
                                    <a href="{{ route('admin.likes.index') }}" class="btn btn-secondary btn-sm">
                                        <i class="bx bx-reset"></i> Reset
                                    </a>
                                </form>
                            </div>
                        </div>

                        @if ($likes->count() > 0)
                            <!-- Bulk Actions Form -->
                            <form id="bulkActionForm" method="POST" action="{{ route('admin.likes.bulk-action') }}">
                                @csrf
                                <input type="hidden" name="action" id="bulkAction" value="">

                                <div class="table-responsive">
                                    <table class="table table-border dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th width="30">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" id="selectAll">
                                                        <label class="form-check-label" for="selectAll"></label>
                                                    </div>
                                                </th>
                                                <th>Type</th>
                                                <th>Liked Content</th>
                                                <th>Liked Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($likes as $like)
                                                <tr>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input like-checkbox" type="checkbox"
                                                                name="like_ids[]" value="{{ $like->id }}">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($like->likeable_type == 'App\Models\Blog')
                                                            <span class="badge bg-primary">Blog Post</span>
                                                        @elseif($like->likeable_type == 'App\Models\Comment')
                                                            <span class="badge bg-success">Comment</span>
                                                        @else
                                                            <span
                                                                class="badge bg-secondary">{{ class_basename($like->likeable_type) }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($like->likeable_type == 'App\Models\Blog' && $like->likeable)
                                                            <div>
                                                                <h6 class="mb-1 font-size-14">
                                                                    <a href="{{ route('blog.show', $like->likeable->slug) }}"
                                                                        target="_blank" class="text-dark">
                                                                        {{ Str::limit($like->likeable->title, 40) }}
                                                                    </a>
                                                                </h6>
                                                                <p class="mb-0 text-muted font-size-12">
                                                                    {{ $like->likeable->slug }}</p>
                                                            </div>
                                                        @elseif($like->likeable_type == 'App\Models\Comment' && $like->likeable)
                                                            <div>
                                                                <p class="mb-1 font-size-14">
                                                                    {{ Str::limit($like->likeable->content, 50) }}</p>
                                                                <p class="mb-0 text-muted font-size-12">Comment on:
                                                                    @if ($like->likeable->blog)
                                                                        <a href="{{ route('blog.show', $like->likeable->blog->slug) }}"
                                                                            target="_blank" class="text-primary">
                                                                            {{ $like->likeable->blog->title }}
                                                                        </a>
                                                                    @else
                                                                        Unknown
                                                                    @endif
                                                                </p>
                                                            </div>
                                                        @else
                                                            <span class="text-muted font-size-12">Content not
                                                                available</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <span
                                                            class="font-size-12">{{ $like->created_at->format('M d, Y') }}</span>
                                                        <p class="mb-0 text-muted font-size-11">
                                                            {{ $like->created_at->format('h:i A') }}</p>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            @if ($like->likeable_type == 'App\Models\Blog' && $like->likeable)
                                                                <a href="{{ route('blog.show', $like->likeable->slug) }}"
                                                                    target="_blank" class="btn btn-primary btn-sm"
                                                                    title="View Content">
                                                                    <i class="bx bx-show"></i>
                                                                </a>
                                                            @endif
                                                            <button type="submit" class="btn btn-danger btn-sm"
                                                                form="delete-form-{{ $like->id }}"
                                                                title="Remove Like"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="bx bx-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </form>

                            @foreach ($likes as $like)
                                <form method="POST" action="{{ route('admin.likes.destroy', $like->id) }}"
                                    style="display: none;" id="delete-form-{{ $like->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            @endforeach

                            <!-- Pagination -->
                            @if ($likes->hasPages())
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between align-items-center mt-3">
                                            <div class="text-muted">
                                                Showing {{ $likes->firstItem() }} to {{ $likes->lastItem() }} of
                                                {{ $likes->total() }} results
                                            </div>
                                            <nav aria-label="Page navigation">
                                                {{ $likes->appends(request()->query())->links('pagination::bootstrap-4') }}
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="text-center py-4">
                                <i class="bx bx-like font-size-48 text-muted"></i>
                                <h5 class="mt-3">No likes found</h5>
                                <p class="text-muted">There are no likes matching your criteria.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const likeCheckboxes = document.querySelectorAll('.like-checkbox');
            const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
            const bulkActionForm = document.getElementById('bulkActionForm');

            // Select all functionality
            selectAllCheckbox.addEventListener('change', function() {
                likeCheckboxes.forEach(checkbox => {
                    checkbox.checked = this.checked;
                });
                toggleBulkActions();
            });

            // Individual checkbox change
            likeCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    const checkedCount = document.querySelectorAll('.like-checkbox:checked').length;
                    selectAllCheckbox.checked = checkedCount === likeCheckboxes.length;
                    selectAllCheckbox.indeterminate = checkedCount > 0 && checkedCount <
                        likeCheckboxes.length;
                    toggleBulkActions();
                });
            });

            // Toggle bulk action buttons
            function toggleBulkActions() {
                const checkedCount = document.querySelectorAll('.like-checkbox:checked').length;
                bulkDeleteBtn.style.display = checkedCount > 0 ? 'inline-block' : 'none';
            }

            // Bulk delete
            bulkDeleteBtn.addEventListener('click', function() {
                const checkedCount = document.querySelectorAll('.like-checkbox:checked').length;
                if (checkedCount > 0 && confirm(
                        `Are you sure you want to delete ${checkedCount} like(s)?`)) {
                    document.getElementById('bulkAction').value = 'delete';
                    bulkActionForm.submit();
                }
            });
        });
    </script>
@endpush
