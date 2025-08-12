@extends('admin.partials.master')
@section('title', 'Home Slide')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Home Slide</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ __('Home Slide') }}</li>
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
                                        :value="old('title', $slide->title)" placeholder="Title" required autofocus
                                        autocomplete="title" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="short_title" :value="__('Short Title')" class="form-label" />
                                    <x-text-input id="short_title" name="short_title" type="text" class="form-control"
                                        :value="old('short_title', $slide->short_title)" placeholder="Short Title" required
                                        autofocus autocomplete="short_title" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('short_title')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="home_slide" :value="__('Home Slide (636px x 852px)')"
                                        class="form-label" />

                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div>
                                            <div class="mt-4 mt-md-0">
                                                <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                    alt="{{ $slide->home_slide ? 'Slide Image' : 'No Image' }}"
                                                    src="{{ $slide->home_slide && str_starts_with($slide->home_slide, 'defaults_images/') ? asset($slide->home_slide) : asset('storage/' . $slide->home_slide) }}"
                                                    data-holder-rendered="true">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="file" id="image" name="home_slide" class="form-control"
                                                accept="image/jpeg,image/jpg,image/png" id="customFile">
                                        </div>
                                        <x-input-error class="text-danger small mt-1"
                                            :messages="$errors->get('home_slide')" />
                                        <small class="text-muted">Supported formats: JPG, JPEG, PNG. Max size: 2MB</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="video_url" :value="__('YouTube Video URL')" class="form-label" />

                                    @if ($slide->video_url)
                                        <div class="mb-3">
                                            <div class="ratio ratio-16x9">
                                                <iframe src="{{ $slide->youtube_embed_url }}" allowfullscreen
                                                    class="rounded"></iframe>
                                            </div>
                                            <small class="text-muted">Current video preview</small>
                                        </div>
                                    @endif

                                    <x-text-input id="video_url" name="video_url" type="url" class="form-control"
                                        :value="old('video_url', $slide->video_url)"
                                        placeholder="https://www.youtube.com/watch?v=example or https://youtu.be/example" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('video_url')" />
                                    <small class="text-muted">Enter a valid YouTube URL (e.g.,
                                        https://www.youtube.com/watch?v=dQw4w9WgXcQ or https://youtu.be/dQw4w9WgXcQ)</small>
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
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#image').change(function () {
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
                        reader.onload = function (e) {
                            $('#showImage').attr('src', e.target.result);
                        };
                        reader.readAsDataURL(file);
                    }
                });
            });

            $(document).ready(function () {
                $('#video_url').on('input', function () {
                    const url = this.value;

                    // Basic YouTube URL validation
                    const youtubeRegex =
                        /^(https?:\/\/)?(www\.)?(youtube\.com\/(watch\?v=|embed\/)|youtu\.be\/)[\w-]+(&[\w=]*)?$/;

                    if (url && !youtubeRegex.test(url)) {
                        $(this).addClass('is-invalid');
                        $(this).next('.text-danger').remove();
                        $(this).after(
                            '<div class="text-danger small mt-1">Please enter a valid YouTube URL</div>');
                        $('#video-preview').hide();
                    } else {
                        $(this).removeClass('is-invalid');
                        $(this).next('.text-danger').remove();

                        if (url && youtubeRegex.test(url)) {
                            // Extract video ID and show preview
                            let videoId = '';
                            const match = url.match(
                                /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/
                            );
                            if (match) {
                                videoId = match[1];
                                const embedUrl = `https://www.youtube.com/embed/${videoId}`;

                                if (!$('#video-preview').length) {
                                    $(this).after(`
                                                                        <div id="video-preview" class="mt-3">
                                                                            <div class="ratio ratio-16x9">
                                                                                <iframe src="${embedUrl}" allowfullscreen class="rounded"></iframe>
                                                                            </div>
                                                                            <small class="text-muted">Live preview</small>
                                                                        </div>
                                                                    `);
                                } else {
                                    $('#video-preview iframe').attr('src', embedUrl);
                                    $('#video-preview').show();
                                }
                            }
                        } else {
                            $('#video-preview').hide();
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection