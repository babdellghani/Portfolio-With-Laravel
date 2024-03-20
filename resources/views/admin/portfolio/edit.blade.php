@extends('admin.partials.master')
@section('title', 'Portfolio Edit')

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <section class="mb-4">

                                <header>
                                    <a href="{{ route('portfolio') }}" class="btn btn-secondary mb-3">
                                        {{ __('Back to List') }}
                                    </a>

                                    <h2 class="fs-4 fw-medium text-dark">
                                        {{ __('Portfolio Information') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Update your Portfolio Information') }}
                                    </p>
                                </header>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="post" action="{{ route('portfolio.update', $portfolio) }}" class="mt-4"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <x-input-label for="title" :value="__('Title')" class="form-label" />
                                        <x-text-input id="title" name="title" type="text" class="form-control"
                                            :value="old('title', $portfolio->title)" placeholder="Title" required autofocus autocomplete="title" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="slug" :value="__('Slug')" class="form-label" />
                                        <x-text-input id="slug" name="slug" type="text" class="form-control"
                                            :value="old('slug', $portfolio->slug)" placeholder="Slug" required autocomplete="slug" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('slug')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="short_description" :value="__('Short Description')" class="form-label" />
                                        <x-textarea id="short_description" name="short_description" type="text"
                                            class="form-control" placeholder="Short Description" required
                                            autocomplete="description">{{ old('short_description', $portfolio->short_description) }}</x-textarea>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('short_description')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="elm1" :value="__('Description')" class="form-label" />
                                        <textarea id="elm1" name="description" class="form-control" placeholder="Description" required
                                            autocomplete="description">
                                        {{ old('description', $portfolio->description) }}
                                        </textarea>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="square-switch" :value="__('Status')" class="form-label" />
                                        <div class="square-switch">
                                            <input type="checkbox" id="square-switch3" switch="bool" name="status" @checked(old('status', $portfolio->status)) />
                                            <label for="square-switch3" data-on-label="Active" data-off-label="Inactive"></label>
                                        </div>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('status')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="category" :value="__('Category')" class="form-label" />
                                        <x-text-input id="category" name="category" type="text" class="form-control"
                                            :value="old('category', $portfolio->category)" placeholder="Category" required autocomplete="category" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('category')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="image" :value="__('Image')" class="form-label" />

                                        <div class="d-flex flex-column align-items-center gap-3">
                                            @if ($portfolio->image)
                                                <div id="image-preview">
                                                    <div class="mt-4 mt-md-0">
                                                        <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                            src="{{ Storage::url($portfolio->image) }}" alt="image"
                                                            data-holder-rendered="true">
                                                    </div>
                                                </div>
                                            @else
                                                <div id="image-preview" class="d-none">
                                                    <div class="mt-4 mt-md-0">
                                                        <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                            src="" data-holder-rendered="true">
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="input-group">
                                                <input type="file" id="image" name="image" class="form-control"
                                                    id="customFile">
                                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('image')" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-3">
                                        <x-primary-button class="btn btn-primary">{{ __('Save') }}</x-primary-button>
                                    </div>
                                </form>

                            </section>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <!--tinymce js-->
        <script src="{{ asset('backend/assets/libs/tinymce/tinymce.min.js') }}"></script>

        <!-- init js -->
        <script src="{{ asset('backend/assets/js/pages/form-editor.init.js') }}"></script>

        <!-- Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#image').change(function() {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);

                    $('#image-preview').removeClass('d-none');
                });

                $('#icon').change(function() {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showIcon').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);

                    $('#icon-preview').removeClass('d-none');
                });
            });
        </script>
    @endpush

@endsection
