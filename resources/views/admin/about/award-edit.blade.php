@extends('admin.partials.master')
@section('title', 'Award Information')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Award</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('award') }}">Awards</a></li>
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
                                <a href="{{ route('award') }}" class="btn btn-secondary mb-3">
                                    {{ __('Back to List') }}
                                </a>

                                <h2 class="fs-4 fw-medium text-dark">
                                    {{ __('Award Information') }}
                                </h2>

                                <p class="mt-1 text-muted small">
                                    {{ __('Update your Award Information') }}
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

                            <form method="post" action="{{ route('award.update', $award) }}" class="mt-4"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="mb-3">
                                    <x-input-label for="title" :value="__('Name')" class="form-label" />
                                    <x-text-input id="title" name="title" type="text" class="form-control"
                                        :value="old('title', $award->title)" placeholder="Name" required autofocus autocomplete="name" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="year" :value="__('Year')" class="form-label" />
                                    <x-text-input id="year" name="year" type="number" class="form-control"
                                        :value="old('year', $award->year)" placeholder="Year" required autocomplete="year" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('year')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="description" :value="__('Description')" class="form-label" />
                                    <x-textarea id="description" name="description" type="text" class="form-control"
                                        placeholder="Description" required
                                        autocomplete="description">{{ old('description', $award->description) }}</x-textarea>
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="image" :value="__('Award Image')" class="form-label" />

                                    <div class="d-flex flex-column align-items-center gap-3">
                                        @if ($award->image)
                                            <div id="image-preview">
                                                <div class="mt-4 mt-md-0">
                                                    <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                        src="{{ $award->image && str_starts_with($award->image, 'defaults_images/') ? asset($award->image) : asset('storage/' . $award->image) }}"
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
