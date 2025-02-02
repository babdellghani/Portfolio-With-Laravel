@extends('admin.partials.master')
@section('title', 'Home Slide')

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <section>

                                <header>
                                    <h2 class="fs-4 fw-medium text-dark">
                                        {{ __('Home Slide') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Update your Home Slide') }}
                                    </p>
                                </header>

                                <form method="post" action="{{ route('home.slide.store') }}" class="mt-4"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <x-input-label for="title" :value="__('Title')" class="form-label" />
                                        <x-text-input id="title" name="title" type="text" class="form-control"
                                            :value="old('title', $slide->title)" placeholder="Title" required autofocus autocomplete="title" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="short_title" :value="__('Short Title')" class="form-label" />
                                        <x-text-input id="short_title" name="short_title" type="text"
                                            class="form-control" :value="old('short_title', $slide->short_title)" placeholder="Short Title" required
                                            autofocus autocomplete="short_title" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('short_title')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="home_slide" :value="__('Home Slide (636px x 852px)')" class="form-label" />

                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <div>
                                                <div class="mt-4 mt-md-0">
                                                        <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                            alt=""
                                                            src="{{ asset('storage/' . $slide->home_slide) }}"
                                                            data-holder-rendered="true">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="file" id="image" name="home_slide" class="form-control"
                                                    accept="image/jpeg,image/jpg,image/png" id="customFile">
                                            </div>
                                            <x-input-error class="text-danger small mt-1" :messages="$errors->get('home_slide')" />
                                            <small class="text-muted">Supported formats: JPG, JPEG, PNG. Max size: 2MB</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="video_url" :value="__('Video')" class="form-label" />

                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <div>
                                                <div class="mt-4 mt-md-0">
                                                        <video id="showVideo" class="rounded img-thumbnail w-100 h-100" controls>
                                                            <source src="{{ asset('storage/' . $slide->video_url) }}" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="file" id="video" name="video_url" class="form-control"
                                                    id="customFile">
                                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('video_url')" />
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


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function() {
                const file = this.files[0];
                
                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                if (file && !allowedTypes.includes(file.type)) {
                    alert('Please select a valid image file (JPG, JPEG, or PNG)');
                    this.value = '';
                    return;
                }
                
                // Validate file size (2MB = 2 * 1024 * 1024 bytes)
                if (file && file.size > 2 * 1024 * 1024) {
                    alert('File size must be less than 2MB');
                    this.value = '';
                    return;
                }
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showImage').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });

        $(document).ready(function() {
            $('#video').change(function() {
                const file = this.files[0];
                
                // Validate file type
                if (file && !file.type.startsWith('video/')) {
                    alert('Please select a valid video file');
                    this.value = '';
                    return;
                }
                
                // Validate file size (10MB = 10 * 1024 * 1024 bytes)
                if (file && file.size > 10 * 1024 * 1024) {
                    alert('Video file size must be less than 10MB');
                    this.value = '';
                    return;
                }
                
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#showVideo').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection
