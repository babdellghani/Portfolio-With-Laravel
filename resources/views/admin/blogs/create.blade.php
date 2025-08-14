@extends('admin.partials.master')

@section('title', 'Create Blog')

@section('content')
    <div class="container-fluid">
        <!-- Page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Create Blog Post</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.blogs.index') }}">Blogs</a></li>
                            <li class="breadcrumb-item active">Create</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <form action="{{ route('admin.blogs.store') }}" method="POST" enctype="multipart/form-data" id="blog-create-form">
            @csrf
            @method('POST')
            <div class="row">
                <!-- Main Content -->
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Blog Content</h4>
                        </div>
                        <div class="card-body">
                            <!-- Title -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Short Description -->
                            <div class="mb-3">
                                <label for="short_description" class="form-label">Short Description</label>
                                <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                    name="short_description" rows="2" placeholder="Brief summary of the blog post...">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4" placeholder="Detailed description of the blog post...">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Excerpt -->
                            <div class="mb-3">
                                <label for="excerpt" class="form-label">Excerpt</label>
                                <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3"
                                    placeholder="Brief description of the blog post...">{{ old('excerpt') }}</textarea>
                                @error('excerpt')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Content -->
                            <div class="mb-3">
                                <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="15">{{ old('content') }}</textarea>
                                @error('content')
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
                            @can('admin', App\Models\Blog::class)
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <div class="square-switch">
                                        <input type="hidden" name="status" value="draft" />
                                        <input type="checkbox" id="square-switch3" value="published" switch="bool"
                                            name="status" @checked(old('status') === 'published') />
                                        <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endcan

                            <!-- Action Buttons -->
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success" id="create-blog-btn">
                                    <i class="mdi mdi-check me-1"></i> Create Blog
                                </button>
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                                    <i class="mdi mdi-arrow-left me-1"></i> Back to Blogs
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Featured Image -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Featured Image</h4>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="thumbnail" class="form-label">Upload Thumbnail</label>
                                <input type="file" class="form-control @error('thumbnail') is-invalid @enderror"
                                    id="thumbnail" name="thumbnail" accept="image/*">
                                @error('thumbnail')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Recommended size: 800x600px. Max size: 2MB</div>
                            </div>

                            <!-- Thumbnail Preview -->
                            <div id="thumbnail-preview" style="display: none;">
                                <img id="preview-thumbnail" src="" alt="Preview" class="img-fluid rounded">
                            </div>
                        </div>
                    </div>

                    <!-- Main Image -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Main Image</h4>
                        </div>
                        <div class="card-body">

                            <div class="mb-3">
                                <label for="image" class="form-label">Upload Main Image</label>
                                <input type="file" class="form-control @error('image') is-invalid @enderror"
                                    id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">Recommended size: 1200x800px. Max size: 5MB</div>

                                <!-- Image Preview -->
                                <div id="image-preview" style="display: none;">
                                    <label class="form-label">New Image Preview</label>
                                    <img id="preview-image" src="" alt="Preview" class="img-fluid rounded">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Categories <span class="text-danger">*</span></h4>
                        </div>
                        <div class="card-body">
                            <div class="categories-list" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('categories') is-invalid @enderror"
                                            type="checkbox" name="categories[]" value="{{ $category->id }}"
                                            id="category_{{ $category->id }}"
                                            {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category_{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('categories')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">Tags</h4>
                        </div>
                        <div class="card-body">
                            <div class="tags-list" style="max-height: 200px; overflow-y: auto;">
                                @foreach ($tags as $tag)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input @error('tags') is-invalid @enderror"
                                            type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                            id="tag_{{ $tag->id }}"
                                            {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="tag_{{ $tag->id }}">
                                            {{ $tag->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">Select relevant tags for your blog post</div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <!-- Include CKEditor -->
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>


        <script>
            document.addEventListener('DOMContentLoaded', function() {
                let editorInstance;
                // Initialize CKEditor
                ClassicEditor
                    .create(document.querySelector('#content'), {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', '|',
                            'outdent', 'indent', '|', 'blockQuote', 'insertTable', 'undo', 'redo'
                        ],
                        height: '400px',
                    })
                    .then(editor => {
                        editorInstance = editor;
                    })
                    .catch(error => {
                        console.error('Error initializing CKEditor:', error);
                    });

                // Form submission debugging
                const form = document.getElementById('blog-create-form');
                const createBtn = document.getElementById('create-blog-btn');

                if (form && createBtn) {
                    form.addEventListener('submit', function(e) {

                        // Check if form is valid
                        const categories = document.querySelectorAll('input[name="categories[]"]:checked');

                        // Get content from CKEditor if available, otherwise from textarea
                        let content = '';
                        if (editorInstance) {
                            content = editorInstance.getData();
                            // Update the hidden textarea with CKEditor content
                            document.getElementById('content').value = content;
                        } else {
                            content = document.getElementById('content').value;
                        }


                        if (!content.trim()) {
                            alert('Please enter content');
                            e.preventDefault();
                            return false;
                        }

                        if (categories.length === 0) {
                            alert('Please select at least one category');
                            e.preventDefault();
                            return false;
                        }

                        // Show loading state
                        createBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Creating...';
                        createBtn.disabled = true;
                        return true;
                    });

                }

                // thumbnail preview
                document.getElementById('thumbnail').addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            const preview = document.getElementById('thumbnail-preview');
                            const img = document.getElementById('preview-thumbnail');
                            img.src = e.target.result;
                            preview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    }
                });

                // image preview
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
                    }
                });
            });
        </script>
    @endpush
@endsection
