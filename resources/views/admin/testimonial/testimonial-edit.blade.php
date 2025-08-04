@extends('admin.partials.master')
@section('title', 'Edit Testimonial')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Testimonial</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('testimonial') }}">Testimonials</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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
                        <section class="mb-4">

                            <header>
                                <a href="{{ route('testimonial') }}" class="btn btn-secondary mb-3">
                                    {{ __('Back to List') }}
                                </a>

                                <h2 class="fs-4 fw-medium text-dark">
                                    {{ __('Edit Testimonial Information') }}
                                </h2>

                                <p class="mt-1 text-muted small">
                                    {{ __('Update your Testimonial Information') }}
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

                            <form method="post" action="{{ route('testimonial.update', $testimonial) }}" class="mt-4"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="mb-3">
                                    <x-input-label for="name" :value="__('Client Name')" class="form-label" />
                                    <x-text-input id="name" name="name" type="text" class="form-control"
                                        :value="old('name', $testimonial->name)" placeholder="Client Name" required autofocus
                                        autocomplete="name" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="title" :value="__('Client Title/Position')" class="form-label" />
                                    <x-text-input id="title" name="title" type="text" class="form-control"
                                        :value="old('title', $testimonial->title)" placeholder="e.g. CEO, Designer, etc." autocomplete="title" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="message" :value="__('Testimonial Message')" class="form-label" />
                                    <x-textarea id="message" name="message" type="text" class="form-control"
                                        placeholder="Testimonial Message" required rows="4"
                                        autocomplete="message">{{ old('message', $testimonial->message) }}</x-textarea>
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('message')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="rating" :value="__('Rating')" class="form-label" />
                                    <select id="rating" name="rating" class="form-control" required>
                                        <option value="">Select Rating</option>
                                        <option value="5"
                                            {{ old('rating', $testimonial->rating) == '5' ? 'selected' : '' }}>5 Stars
                                        </option>
                                        <option value="4"
                                            {{ old('rating', $testimonial->rating) == '4' ? 'selected' : '' }}>4 Stars
                                        </option>
                                        <option value="3"
                                            {{ old('rating', $testimonial->rating) == '3' ? 'selected' : '' }}>3 Stars
                                        </option>
                                        <option value="2"
                                            {{ old('rating', $testimonial->rating) == '2' ? 'selected' : '' }}>2 Stars
                                        </option>
                                        <option value="1"
                                            {{ old('rating', $testimonial->rating) == '1' ? 'selected' : '' }}>1 Star
                                        </option>
                                    </select>
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('rating')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="image" :value="__('Client Image')" class="form-label" />

                                    <div class="d-flex flex-column align-items-center gap-3">
                                        <div id="image-preview" class="{{ $testimonial->image ? '' : 'd-none' }}">
                                            <div class="mt-4 mt-md-0">
                                                <img id="showImage" class="rounded img-thumbnail"
                                                    src="{{ $testimonial->image ? ($testimonial->image && str_starts_with($testimonial->image, 'defaults_images/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image)) : '' }}"
                                                    data-holder-rendered="true"
                                                    style="width: 150px; height: 150px; object-fit: cover;">
                                            </div>
                                        </div>
                                        <div class="input-group">
                                            <input type="file" id="image" name="image" class="form-control"
                                                id="customFile">
                                            <x-input-error class="text-danger small mt-1" :messages="$errors->get('image')" />
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <x-input-label for="square-switch" :value="__('Status')" class="form-label" />
                                        <div class="square-switch">
                                            <input type="checkbox" id="square-switch3" switch="bool" value="1"
                                                name="status" @checked(old('status', $testimonial->status)) />
                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                        </div>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('status')" />
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <x-primary-button class="btn btn-primary">{{ __('Update') }}</x-primary-button>
                                </div>
                            </form>

                        </section>

                    </div>
                </div>

            </div>
        </div>
    </div>


    @push('scripts')
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
            });
        </script>
    @endpush

@endsection
