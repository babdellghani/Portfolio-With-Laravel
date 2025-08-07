@extends('admin.admin_master')

@section('title', 'Manage Comments')

@section('admin')
<div class="page-content">
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Manage Comments</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Comments</li>
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
                                    <form method="GET" action="{{ route('admin.comments.index') }}">
                                        <div class="position-relative">
                                            <input type="text" name="search" class="form-control" placeholder="Search comments..." value="{{ request('search') }}">
                                            <i class="bx bx-search-alt search-icon"></i>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.comments.stats') }}" class="btn btn-info btn-rounded waves-effect waves-light mb-2 me-2">
                                        <i class="mdi mdi-chart-line me-1"></i> Statistics
                                    </a>
                                    <a href="{{ route('admin.comments.export') }}" class="btn btn-success btn-rounded waves-effect waves-light mb-2">
                                        <i class="mdi mdi-download me-1"></i> Export CSV
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Filters -->
                        <div class="row">
                            <div class="col-lg-12">
                                <form method="GET" action="{{ route('admin.comments.index') }}" class="row g-3">
                                    <div class="col-lg-3">
                                        <select name="status" class="form-select">
                                            <option value="">All Status</option>
                                            <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <select name="blog_id" class="form-select">
                                            <option value="">All Blogs</option>
                                            @foreach($blogs as $blog)
                                                <option value="{{ $blog->id }}" {{ request('blog_id') == $blog->id ? 'selected' : '' }}>
                                                    {{ Str::limit($blog->title, 50) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bx bx-filter-alt me-1"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
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

        <!-- Comments Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <!-- Bulk Actions -->
                        <form id="bulk-action-form" method="POST" action="{{ route('admin.comments.bulk-action') }}">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="d-flex align-items-center">
                                        <select name="action" class="form-select me-2" style="width: auto;" required>
                                            <option value="">Bulk Actions</option>
                                            <option value="approve">Approve</option>
                                            <option value="reject">Reject</option>
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
                                            <th class="align-middle">Comment</th>
                                            <th class="align-middle">Blog Post</th>
                                            <th class="align-middle">Author</th>
                                            <th class="align-middle">Status</th>
                                            <th class="align-middle">Date</th>
                                            <th class="align-middle">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($comments as $comment)
                                        <tr class="{{ $comment->parent_id ? 'table-warning' : '' }}">
                                            <td>
                                                <div class="form-check font-size-16">
                                                    <input class="form-check-input" type="checkbox" name="comments[]" value="{{ $comment->id }}">
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-start">
                                                    @if($comment->parent_id)
                                                        <i class="ri-corner-down-right-line text-muted me-2 mt-1"></i>
                                                    @endif
                                                    <div class="flex-grow-1">
                                                        <p class="mb-1">{{ Str::limit($comment->content, 100) }}</p>
                                                        @if($comment->parent_id)
                                                            <small class="text-muted">
                                                                Reply to: {{ Str::limit($comment->parent->content ?? 'Deleted comment', 50) }}
                                                            </small>
                                                        @endif
                                                        @if($comment->replies->count() > 0)
                                                            <div class="mt-1">
                                                                <small class="badge bg-soft-info text-info">
                                                                    {{ $comment->replies->count() }} {{ Str::plural('reply', $comment->replies->count()) }}
                                                                </small>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('blog.show', $comment->blog->slug) }}" target="_blank" class="text-dark">
                                                    {{ Str::limit($comment->blog->title, 40) }}
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar-xs">
                                                            <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                                        <p class="text-muted font-size-13 mb-0">{{ $comment->user->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-pill badge-soft-{{ $comment->status ? 'success' : 'warning' }} font-size-12">
                                                    {{ $comment->status ? 'Approved' : 'Pending' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $comment->created_at->format('M d, Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $comment->created_at->format('H:i A') }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-2 flex-wrap">
                                                    @if(!$comment->status)
                                                        <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                                <i class="mdi mdi-check"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-warning" title="Reject">
                                                                <i class="mdi mdi-close"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    
                                                    <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-sm btn-info" title="View">
                                                        <i class="mdi mdi-eye"></i>
                                                    </a>
                                                    
                                                    <a href="{{ route('admin.comments.edit', $comment) }}" class="btn btn-sm btn-primary" title="Edit">
                                                        <i class="mdi mdi-pencil"></i>
                                                    </a>
                                                    
                                                    <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure? This will also delete all replies.')" title="Delete">
                                                            <i class="mdi mdi-delete"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4">
                                                <div class="text-muted">
                                                    <i class="ri-chat-3-line font-size-48 d-block mb-3"></i>
                                                    <h5>No comments found</h5>
                                                    <p>Comments will appear here when users start engaging with your blog posts.</p>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </form>

                        <!-- Pagination -->
                        @if($comments->hasPages())
                        <div class="row">
                            <div class="col-lg-12">
                                <ul class="pagination pagination-rounded justify-content-end mb-2">
                                    {{ $comments->links() }}
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check All functionality
    document.getElementById('checkAll').addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('input[name="comments[]"]');
        checkboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
    });

    // Bulk action form validation
    document.getElementById('bulk-action-form').addEventListener('submit', function(e) {
        const selectedComments = document.querySelectorAll('input[name="comments[]"]:checked');
        const action = document.querySelector('select[name="action"]').value;
        
        if (selectedComments.length === 0) {
            e.preventDefault();
            alert('Please select at least one comment.');
            return;
        }
        
        if (!action) {
            e.preventDefault();
            alert('Please select an action.');
            return;
        }
        
        if (action === 'delete') {
            if (!confirm('Are you sure you want to delete the selected comments? This will also delete all their replies.')) {
                e.preventDefault();
            }
        }
    });
});
</script>

<style>
.table-warning {
    --bs-table-accent-bg: var(--bs-warning-bg-subtle);
}
</style>
@endsection
