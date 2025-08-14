@extends('admin.partials.master')

@section('title', 'Comment Details')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Comment Details</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.comments.index') }}">Comments</a></li>
                            <li class="breadcrumb-item active">Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-8">
                <!-- Comment Details -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center justify-content-between">
                            <h4 class="card-title mb-0">Comment #{{ $comment->id }}</h4>
                            <div>
                                <span
                                    class="badge badge-pill badge-soft-{{ $comment->status ? 'success' : 'warning' }} font-size-12">
                                    {{ $comment->status ? 'Approved' : 'Pending' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if ($comment->parent_id)
                            <div class="alert alert-info d-flex align-items-start">
                                <i class="ri-corner-down-right-line me-2 mt-1"></i>
                                <div>
                                    <strong>This is a reply to:</strong>
                                    <p class="mb-0 mt-1">{{ $comment->parent->content ?? 'Deleted comment' }}</p>
                                </div>
                            </div>
                        @endif

                        <div class="comment-content">
                            <h6 class="text-muted mb-2">Comment Content:</h6>
                            <div class="bg-light p-3 rounded">
                                {{ $comment->content }}
                            </div>
                        </div>

                        @if ($comment->replies->count() > 0)
                            <div class="mt-4">
                                <h6 class="text-muted mb-3">Replies ({{ $comment->replies->count() }}):</h6>
                                <div class="replies-list">
                                    @foreach ($comment->replies as $reply)
                                        <div class="d-flex mb-3 p-3 bg-light rounded">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <span class="avatar-title rounded-circle bg-soft-primary text-primary">
                                                        {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <h6 class="mb-0">{{ $reply->user->name }}</h6>
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="badge badge-pill badge-soft-{{ $reply->status ? 'success' : 'warning' }} font-size-11 me-2">
                                                            {{ $reply->status ? 'Approved' : 'Pending' }}
                                                        </span>
                                                        <small
                                                            class="text-muted">{{ $reply->created_at->diffForHumans() }}</small>
                                                    </div>
                                                </div>
                                                <p class="text-muted mb-2">{{ $reply->content }}</p>
                                                <div class="d-flex gap-2">
                                                    @if (!$reply->status)
                                                        <form action="{{ route('admin.comments.approve', $reply) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-success">
                                                                <i class="mdi mdi-check me-1"></i> Approve
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('admin.comments.reject', $reply) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" class="btn btn-sm btn-warning">
                                                                <i class="mdi mdi-close me-1"></i> Reject
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('admin.comments.edit', $reply) }}"
                                                        class="btn btn-sm btn-primary">
                                                        <i class="mdi mdi-pencil me-1"></i> Edit
                                                    </a>
                                                    <form action="{{ route('admin.comments.destroy', $reply) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="mdi mdi-delete me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <!-- Comment Actions -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Actions</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            @can('admin', Comment::class)
                                @if (!$comment->status)
                                    <form action="{{ route('admin.comments.approve', $comment) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-success w-100">
                                            <i class="mdi mdi-check me-1"></i> Approve Comment
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.comments.reject', $comment) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-warning w-100">
                                            <i class="mdi mdi-close me-1"></i> Reject Comment
                                        </button>
                                    </form>
                                @endif
                            @endcan

                            <a href="{{ route('admin.comments.edit', $comment) }}" class="btn btn-primary">
                                <i class="mdi mdi-pencil me-1"></i> Edit Comment
                            </a>

                            <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100"
                                    onclick="return confirm('Are you sure? This will also delete all replies.')">
                                    <i class="mdi mdi-delete me-1"></i> Delete Comment
                                </button>
                            </form>

                            <a href="{{ route('admin.comments.index') }}" class="btn btn-secondary">
                                <i class="mdi mdi-arrow-left me-1"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>

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
                                        <th class="ps-0" scope="row">Status:</th>
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
                                        <th class="ps-0" scope="row">Updated:</th>
                                        <td class="text-muted">{{ $comment->updated_at->format('M d, Y H:i A') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Type:</th>
                                        <td class="text-muted">{{ $comment->parent_id ? 'Reply' : 'Comment' }}</td>
                                    </tr>
                                    @if ($comment->replies->count() > 0)
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
                        <h4 class="card-title mb-0">Author Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
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
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">User ID:</th>
                                        <td class="text-muted">#{{ $comment->user->id }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Joined:</th>
                                        <td class="text-muted">{{ $comment->user->created_at->format('M d, Y') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Total Comments:</th>
                                        <td class="text-muted">{{ $comment->user->comments()->count() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        @can('admin', Comment::class)
                            <div class="mt-3">
                                <a href="{{ route('users.show', $comment->user) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="mdi mdi-account me-1"></i> View User Profile
                                </a>
                            </div>
                        @endcan
                    </div>
                </div>

                <!-- Blog Post Info -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Blog Post</h4>
                    </div>
                    <div class="card-body">
                        @if ($comment->blog->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $comment->blog->image) }}"
                                    alt="{{ $comment->blog->title }}" class="img-fluid rounded">
                            </div>
                        @endif
                        <h6 class="mb-2">{{ $comment->blog->title }}</h6>
                        <p class="text-muted mb-3">{{ Str::limit($comment->blog->description, 100) }}</p>
                        <div class="d-grid gap-2">
                            <a href="{{ route('blog.show', $comment->blog->slug) }}" target="_blank"
                                class="btn btn-sm btn-outline-primary">
                                <i class="mdi mdi-open-in-new me-1"></i> View Post
                            </a>
                            @can('view', $comment->blog)
                                <a href="{{ route('admin.blogs.edit', $comment->blog) }}"
                                    class="btn btn-sm btn-outline-secondary">
                                    <i class="mdi mdi-pencil me-1"></i> Edit Post
                                </a>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
