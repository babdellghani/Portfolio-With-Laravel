@extends('admin.partials.master')
@section('title', 'About Information')

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
                                        <x-input-label for="short_title" :value="__('Short Title')" class="form-label" />
                                        <x-text-input id="short_title" name="short_title" type="text"
                                            class="form-control" :value="old('short_title', $about->short_title)" placeholder="Short Title" required
                                            autocomplete="title" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('short_title')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="short_description" :value="__('Short Description')" class="form-label" />
                                        <x-text-input id="short_description" name="short_description" type="text"
                                            class="form-control" :value="old('short_description', $about->short_description)" placeholder="Short Description" required
                                            autocomplete="description" />
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
                                                    @if ($about->about_image)
                                                        <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                            alt=""
                                                            src="{{ asset('storage/' . $about->about_image) }}"
                                                            data-holder-rendered="true">
                                                    @else
                                                        <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                            alt=""
                                                            src="{{ asset('backend/assets/images/users/avatar-1.jpg') }}"
                                                            data-holder-rendered="true">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="file" id="image" name="about_image" class="form-control"
                                                    id="customFile">
                                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('about_image')" />
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
                });
            });
        </script>
    @endpush
@endsection
