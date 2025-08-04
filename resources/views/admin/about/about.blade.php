@extends('admin.partials.master')
@section('title', 'About Information')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">About Information</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">About Information</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->
        <div class="row">
            <div class="col-12 col-sm-8" style="width: 100% !important;">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <section>

                            <header>
                                <h2 class="fs-4 fw-medium text-dark">
                                    {{ __('About Information') }}
                                </h2>

                                <p class="mt-1 text-muted small">
                                    {{ __('Update your About Information') }}
                                </p>
                            </header>

                            <form method="post" action="{{ route('about.store') }}" class="mt-4"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <x-input-label for="title" :value="__('Title')" class="form-label" />
                                    <x-text-input id="title" name="title" type="text" class="form-control"
                                        :value="old('title', $about->title)" placeholder="Title" required autofocus autocomplete="title" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="short_title" :value="__('Short Title (Experience)')" class="form-label" />
                                    <x-textarea id="short_title" name="short_title" type="text" class="form-control"
                                        placeholder="Short Title" rows="3" required
                                        autocomplete="title">{{ old('short_title', $about->short_title) }}</x-textarea>
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('short_title')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="short_description" :value="__('Short Description')" class="form-label" />
                                    <x-textarea id="short_description" name="short_description" rows="10"
                                        class="form-control" placeholder="Short Description" height="150" required
                                        autocomplete="description">{{ old('short_description', $about->short_description) }}</x-textarea>
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('short_description')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="elm1" :value="__('Description')" class="form-label" />
                                    <textarea id="elm1" name="long_description" class="form-control" placeholder="Description" required
                                        autocomplete="description">
                                        {{ old('long_description', $about->long_description) }}
                                        </textarea>
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('long_description')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="about_image" :value="__('About Image')" class="form-label" />

                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div>
                                            <div class="mt-4 mt-md-0">
                                                <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                    src="{{ $about->about_image && str_starts_with($about->about_image, 'defaults_images/') ? asset($about->about_image) : asset('storage/' . $about->about_image) }}"
                                                    data-holder-rendered="true">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="file" id="image" name="about_image" class="form-control"
                                                id="customFile">
                                            <x-input-error class="text-danger small mt-1" :messages="$errors->get('about_image')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="cv_file" :value="__('Curriculum Vitae (CV)')" class="form-label" />

                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div class="w-100">
                                            <div class="mt-4 mt-md-0 w-100">
                                                <iframe
                                                    src="{{ $about->cv_file && str_starts_with($about->cv_file, 'defaults_images/') ? asset($about->cv_file) : asset('storage/' . $about->cv_file) }}"
                                                    id="showPdf" type="application/pdf" frameBorder="0" scrolling="auto"
                                                    style="width: 100%; height: 500px"></iframe>
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="file" id="pdf" name="cv_file" class="form-control"
                                                id="customFile">
                                            <x-input-error class="text-danger small mt-1" :messages="$errors->get('cv_file')" />
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
                });
            });
            $(document).ready(function() {
                $('#pdf').change(function() {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showPdf').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                });
            });
        </script>
    @endpush
@endsection
