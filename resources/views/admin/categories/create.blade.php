@extends('admin.partials.master')

@section('title', 'Create Category')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Category</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.categories.index') }}">Categories</a>
                            </li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Category Information</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Category Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Category Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Brief description of the category...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category Image -->
                            <div class="mb-3">
                                <label for="image" class="form-label">Category Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Recommended size: 400x300px. Max size: 2MB</div>
                            </div>

                            <!-- Image Preview -->
                            <div id="image-preview" style="display: none;" class="mb-3">
                                <label class="form-label">Image Preview</label>
                                <div>
                                    <img id="preview-image" src="" alt="Preview" class="img-fluid rounded"
                                        style="max-height: 200px;">
                                </div>
                            </div>

                            <!-- Status -->
                            @can('admin', Category::class)
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="square-switch">
                                        <input type="hidden" name="status" value="0" />
                                        <input type="checkbox" id="square-switch3" value="1" switch="bool" name="status"
                                            @checked(old('status') === 'published') />
                                        <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endcan

                            <!-- Action Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    <i class="mdi mdi-check me-1"></i> Create Category
                                </button>
                                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back to Categories
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Category Guidelines</h4>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <h6 class="alert-heading">Tips for creating categories:</h6>
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
    </div>
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Image preview functionality
                document.getElementById('image').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
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

                // Auto-generate slug preview (optional)
                document.getElementById('name').addEventListener('input', function(e) {
                    const name = e.target.value;
                    const slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-|-$/g, '');
                    // You can display the slug preview here if needed
                });
            });
        </script>
    @endpush
@endsection
