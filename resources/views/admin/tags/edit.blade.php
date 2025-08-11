@extends('admin.partials.master')

@section('title', 'Edit Tag')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Tag</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.tags.update', $tag) }}" method="POST" id="tag-edit-form">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Tag Information</h4>
                        </div>
                        <div class="card-body">
                            <!-- Tag Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Tag Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $tag->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Use descriptive names that help categorize your content</div>
                            </div>

                            <!-- Current Slug Display -->
                            <div class="mb-3">
                                <label class="form-label">Current Slug</label>
                                <div class="form-control-plaintext bg-light px-3 py-2 rounded">
                                    <code>{{ $tag->slug }}</code>
                                </div>
                                <small class="text-muted">Slug will be auto-generated from the tag name</small>
                            </div>

                            <!-- Tag Preview -->
                            <div class="mb-3">
                                <label class="form-label">Tag Preview</label>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-primary me-2" id="tag-preview">{{ $tag->name }}</span>
                                    <small class="text-muted">This is how your tag will appear</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tag Guidelines -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Tag Guidelines</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">Best Practices for Tags:</h6>
                                <ul class="mb-0 small">
                                    <li>Keep tag names short and descriptive</li>
                                    <li>Use lowercase for consistency</li>
                                    <li>Avoid special characters and spaces</li>
                                    <li>Use specific rather than generic terms</li>
                                    <li>Consider how users might search for content</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <h6 class="alert-heading">Important Notes:</h6>
                                <ul class="mb-0 small">
                                    <li>Tag names must be unique across the system</li>
                                    <li>Changing tag names may affect SEO and URLs</li>
                                    <li>Deactivated tags won't appear in public areas</li>
                                    <li>Tags with associated blogs cannot be deleted</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <!-- Publish Options -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Publish Options</h4>
                        </div>
                        <div class="card-body">
                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <div class="square-switch">
                                    <input type="hidden" name="status" value="0" />
                                    <input type="checkbox" id="square-switch3" value="1" switch="bool" name="status"
                                        @checked(old('status', $tag->status)) />
                                    <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    {{ $tag->status ? 'Active - Tag is visible and usable' : 'Inactive - Tag is hidden from public view' }}
                                </div>
                            </div>

                            <!-- Tag Statistics -->
                            <div class="mb-3">
                                <label class="form-label">Statistics</label>
                                <div class="bg-light p-3 rounded">
                                    <div class="row text-center">
                                        <div class="col-6">
                                            <h5 class="mb-1 text-primary">{{ $tag->blogs_count ?? $tag->blogs()->count() }}
                                            </h5>
                                            <p class="text-muted mb-0 small">Blog Posts</p>
                                        </div>
                                        <div class="col-6">
                                            <h5 class="mb-1 text-{{ $tag->status ? 'success' : 'danger' }}">
                                                {{ $tag->status ? 'Active' : 'Inactive' }}
                                            </h5>
                                            <p class="text-muted mb-0 small">Status</p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Creation Info -->
                            <div class="mb-3">
                                <label class="form-label">Tag Details</label>
                                <div class="text-muted small">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Created by:</span>
                                        <span>{{ $tag->user->name }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Created on:</span>
                                        <span>{{ $tag->created_at->format('M d, Y') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span>Last updated:</span>
                                        <span>{{ $tag->updated_at->format('M d, Y') }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success" id="update-tag-btn">
                                    <i class="mdi mdi-check me-1"></i> Update Tag
                                </button>
                                <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back to Tags
                                </a>
                                @if($tag->blogs()->count() === 0)
                                    <button type="button" class="btn btn-danger" onclick="deleteTag()">
                                        <i class="mdi mdi-delete me-1"></i> Delete Tag
                                    </button>
                                @else
                                    <div class="alert alert-warning small p-2 mb-0">
                                        <i class="mdi mdi-alert me-1"></i>
                                        Cannot delete: Tag is used in {{ $tag->blogs()->count() }} blog post(s)
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Related Blogs -->
                    @if($tag->blogs()->count() > 0)
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Related Blog Posts</h4>
                            </div>
                            <div class="card-body">
                                <div class="list-group list-group-flush">
                                    @foreach($tag->blogs()->latest()->take(5)->get() as $blog)
                                        <div class="list-group-item px-0 py-2">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    @if($blog->thumbnail)
                                                        <img src="{{ $blog->thumbnail && str_starts_with($blog->thumbnail, 'defaults_images/') ? asset($blog->thumbnail) : asset('storage/' . $blog->thumbnail) }}"
                                                            alt="Blog thumbnail" class="avatar-sm rounded">
                                                    @else
                                                        <div class="avatar-sm">
                                                            <span class="avatar-title rounded bg-soft-primary text-primary">
                                                                <i class="ri-file-text-line"></i>
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 font-size-14">
                                                        <a href="{{ route('admin.blogs.edit', $blog) }}" class="text-dark">
                                                            {{ Str::limit($blog->title, 35) }}
                                                        </a>
                                                    </h6>
                                                    <p class="text-muted mb-0 font-size-12">
                                                        <span
                                                            class="badge badge-soft-{{ $blog->status === 'published' ? 'success' : 'warning' }} font-size-11 me-1">
                                                            {{ ucfirst($blog->status) }}
                                                        </span>
                                                        {{ $blog->created_at->format('M d, Y') }}
                                                        @if($blog->views > 0)
                                                            • {{ $blog->views }} views
                                                        @endif
                                                    </p>
                                                </div>
                                                <div class="flex-shrink-0">
                                                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-soft-primary">
                                                        <i class="ri-edit-line"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if($tag->blogs()->count() > 5)
                                    <div class="text-center mt-3">
                                        <a href="{{ route('admin.blogs.index', ['tag_id' => $tag->id]) }}"
                                            class="btn btn-soft-primary btn-sm">
                                            <i class="ri-eye-line me-1"></i>
                                            View all {{ $tag->blogs()->count() }} blog posts
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" id="delete-form" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Form submission handling
            const form = document.getElementById('tag-edit-form');
            const updateBtn = document.getElementById('update-tag-btn');
            const nameInput = document.getElementById('name');
            const tagPreview = document.getElementById('tag-preview');

            if (form && updateBtn) {
                form.addEventListener('submit', function (e) {
                    const name = nameInput.value.trim();

                    if (!name) {
                        alert('Please enter a tag name');
                        e.preventDefault();
                        return false;
                    }

                    if (name.length < 2) {
                        alert('Tag name must be at least 2 characters long');
                        e.preventDefault();
                        return false;
                    }

                    // Show loading state
                    updateBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Updating...';
                    updateBtn.disabled = true;
                    return true;
                });
            }

            // Real-time tag preview
            if (nameInput && tagPreview) {
                nameInput.addEventListener('input', function (e) {
                    const name = e.target.value.trim();
                    tagPreview.textContent = name || '{{ $tag->name }}';
                });
            }

            // Auto-generate slug preview
            nameInput.addEventListener('input', function (e) {
                const name = e.target.value;
                const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                // You can display the slug preview here if needed
            });
        });

        // Delete tag function
        function deleteTag() {
            if (confirm('Are you sure you want to delete this tag? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endsection