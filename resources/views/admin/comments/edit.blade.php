@extends('admin.partials.master')

@section('title', 'Edit Comment')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Comment</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Comments</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <!-- Edit Form -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Edit Comment #{{ $comment->id }}</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.comments.update', $comment) }}" method="POST">
                            @csrf
                            @method('PUT')

                            @if($comment->parent_id)
                                <div class="alert alert-info d-flex align-items-start mb-4">
                                    <i class="ri-corner-down-right-line me-2 mt-1"></i>
                                    <div>
                                        <strong>This is a reply to:</strong>
                                        <p class="mb-0 mt-1">{{ $comment->parent->content ?? 'Deleted comment' }}</p>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="content" class="form-label">Comment Content <span
                                        class="text-danger">*</span></label>
                                <textarea name="content" id="content"
                                    class="form-control @error('content') is-invalid @enderror" rows="6"
                                    required>{{ old('content', $comment->content) }}</textarea>
                                @error('content')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-text">
                                    Character count: <span id="char-count">{{ strlen($comment->content) }}</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                                    <option value="0" {{ old('status', $comment->status) == 0 ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="1" {{ old('status', $comment->status) == 1 ? 'selected' : '' }}>
                                        Approved</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="admin_note" class="form-label">Admin Note (Internal)</label>
                                <textarea name="admin_note" id="admin_note"
                                    class="form-control @error('admin_note') is-invalid @enderror" rows="3"
                                    placeholder="Internal note for admins (not visible to users)">{{ old('admin_note', $comment->admin_note ?? '') }}</textarea>
                                @error('admin_note')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="form-text">This note is only visible to administrators and won't be shown to
                                    users.</div>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin.comments.show', $comment) }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="mdi mdi-content-save me-1"></i> Update Comment
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Comment Info -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Comment Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">ID:</th>
                                        <td class="text-muted">#{{ $comment->id }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Current Status:</th>
                                        <td>
                                            <span
                                                class="badge badge-pill badge-soft-{{ $comment->status ? 'success' : 'warning' }} font-size-12">
                                                {{ $comment->status ? 'Approved' : 'Pending' }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Created:</th>
                                        <td class="text-muted">{{ $comment->created_at->format('M d, Y H:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Type:</th>
                                        <td class="text-muted">{{ $comment->parent_id ? 'Reply' : 'Comment' }}</td>
                                    </tr>
                                    @if($comment->replies->count() > 0)
                                        <tr>
                                            <th class="ps-0" scope="row">Replies:</th>
                                            <td class="text-muted">{{ $comment->replies->count() }}</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Author Info -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Author</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0 me-3">
                                <div class="avatar-sm">
                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-0">{{ $comment->user->name }}</h6>
                                <p class="text-muted mb-0">{{ $comment->user->email }}</p>
                            </div>
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('admin.users.show', $comment->user) }}"
                                class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-account me-1"></i> View Profile
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Blog Post -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Blog Post</h4>
                    </div>
                    <div class="card-body">
                        @if($comment->blog->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $comment->blog->image) }}" alt="{{ $comment->blog->title }}"
                                    class="img-fluid rounded">
                            </div>
                        @endif
                        <h6 class="mb-2">{{ $comment->blog->title }}</h6>
                        <p class="text-muted mb-3">{{ Str::limit($comment->blog->description, 100) }}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('blog.show', $comment->blog->slug) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-open-in-new me-1"></i> View Post
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Quick Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @if(!$comment->status)
                                <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="mdi mdi-check me-1"></i> Quick Approve
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-warning btn-sm">
                                        <i class="mdi mdi-close me-1"></i> Quick Reject
                                    </button>
                                </form>
                            @endif

                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Are you sure? This will also delete all replies.')">
                                    <i class="mdi mdi-delete me-1"></i> Delete Comment
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Character count
            const contentTextarea = document.getElementById('content');
            const charCount = document.getElementById('char-count');

            if (contentTextarea && charCount) {
                contentTextarea.addEventListener('input', function () {
                    charCount.textContent = this.value.length;
                });
            }
        });
    </script>
@endsection