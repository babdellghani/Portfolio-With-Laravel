@extends('admin.partials.master')

@section('title', 'Edit Category')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Category</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data"
            id="category-edit-form">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Category Information</h4>
                        </div>
                        <div class="card-body">
                            <!-- Category Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Slug Display -->
                            <div class="mb-3">
                                <label class="form-label">Current Slug</label>
                                <div class="form-control-plaintext text-muted">{{ $category->slug }}</div>
                                <small class="text-muted">Slug will be auto-generated from the category name</small>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                    name="description" rows="4"
                                    placeholder="Brief description of the category...">{{ old('description', $category->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                        @checked(old('status', $category->status)) />
                                    <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                </div>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category Stats -->
                            <div class="mb-3">
                                <label class="form-label">Statistics</label>
                                <div class="d-flex justify-content-between text-muted small">
                                    <span>Blogs: {{ $category->blogs_count ?? $category->blogs()->count() }}</span>
                                    <span>Status: {{ $category->status ? 'Active' : 'Inactive' }}</span>
                                </div>
                                <div class="text-muted small mt-1">
                                    Created: {{ $category->created_at->format('M d, Y') }}
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success" id="update-category-btn">
                                    <i class="mdi mdi-check me-1"></i> Update Category
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back to Categories
                                </a>
                                @if($category->blogs()->count() === 0)
                                    <button type="button" class="btn btn-danger" onclick="deleteCategory()">
                                        <i class="mdi mdi-delete me-1"></i> Delete Category
                                    </button>
                                @else
                                    <div class="alert alert-warning small p-2 mb-0">
                                        <i class="mdi mdi-alert me-1"></i>
                                        Cannot delete: Category has {{ $category->blogs()->count() }} blog post(s)
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Category Image -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Category Image</h4>
                        </div>
                        <div class="card-body">
                            <!-- Current Image -->
                            @if($category->image)
                                <div class="mb-3">
                                    <label class="form-label">Current Image</label>
                                    <div class="current-image">
                                        <img src="{{ asset('storage/' . $category->image) }}" alt="Current category image"
                                            class="img-fluid rounded">
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label for="image"
                                    class="form-label">{{ $category->image ? 'Replace Image' : 'Upload Image' }}</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                                    name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Recommended size: 400x300px. Max size: 2MB</div>
                            </div>

                            <!-- Image Preview -->
                            <div id="image-preview" style="display: none;">
                                <label class="form-label">New Image Preview</label>
                                <img id="preview-image" src="" alt="Preview" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <!-- Category Guidelines -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Category Guidelines</h4>
                        </div>
                        <div class="card-body">
                            <div class="alert alert-info">
                                <h6 class="alert-heading">Tips for editing categories:</h6>
                                <ul class="mb-0 small">
                                    <li>Use clear, descriptive names</li>
                                    <li>Keep names concise (2-3 words max)</li>
                                    <li>Avoid duplicate categories</li>
                                    <li>Add descriptions to help users understand the category purpose</li>
                                    <li>Upload relevant images to make categories more appealing</li>
                                </ul>
                            </div>

                            <div class="alert alert-warning">
                                <h6 class="alert-heading">Image Requirements:</h6>
                                <ul class="mb-0 small">
                                    <li>Supported formats: JPEG, PNG, JPG, GIF</li>
                                    <li>Maximum file size: 2MB</li>
                                    <li>Recommended dimensions: 400x300px</li>
                                    <li>Use high-quality, relevant images</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <!-- Hidden Delete Form -->
        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" id="delete-form"
            style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Form submission handling
            const form = document.getElementById('category-edit-form');
            const updateBtn = document.getElementById('update-category-btn');

            if (form && updateBtn) {
                form.addEventListener('submit', function (e) {
                    const name = document.getElementById('name').value.trim();

                    if (!name) {
                        alert('Please enter a category name');
                        e.preventDefault();
                        return false;
                    }

                    // Show loading state
                    updateBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Updating...';
                    updateBtn.disabled = true;
                    return true;
                });
            }

            // Image preview functionality
            document.getElementById('image').addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        const preview = document.getElementById('image-preview');
                        const img = document.getElementById('preview-image');
                        img.src = e.target.result;
                        preview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    document.getElementById('image-preview').style.display = 'none';
                }
            });

            // Auto-generate slug preview
            document.getElementById('name').addEventListener('input', function (e) {
                const name = e.target.value;
                const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                // You can display the slug preview here if needed
            });
        });

        // Delete category function
        function deleteCategory() {
            if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                document.getElementById('delete-form').submit();
            }
        }
    </script>
@endsection