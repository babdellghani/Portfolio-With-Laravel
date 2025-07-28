@extends('admin.partials.master')
@section('title', 'Services')

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <section class="mb-4">

                                <header>
                                    <h2 class="fs-4 fw-medium text-dark">
                                        {{ __('Services Information') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Create and Update your Services Information') }}
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

                                <form method="post" action="{{ route('service.store') }}" class="mt-4"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <x-input-label for="title" :value="__('Title')" class="form-label" />
                                        <x-text-input id="title" name="title" type="text" class="form-control"
                                            :value="old('title')" placeholder="Title" required autofocus autocomplete="title" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="slug" :value="__('Slug')" class="form-label" />
                                        <x-text-input id="slug" name="slug" type="text" class="form-control"
                                            :value="old('slug')" placeholder="Slug" required autocomplete="slug" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('slug')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="short_description" :value="__('Short Description')" class="form-label" />
                                        <x-textarea id="short_description" name="short_description" type="text"
                                            class="form-control" placeholder="Short Description" required
                                            autocomplete="description">{{ old('short_description') }}</x-textarea>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('short_description')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="elm1" :value="__('Description')" class="form-label" />
                                        <textarea id="elm1" name="description" class="form-control" placeholder="Description" required
                                            autocomplete="description">
                                        {{ old('description') }}
                                        </textarea>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="image" :value="__('Image')" class="form-label" />

                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <div id="image-preview" class="d-none">
                                                <div class="mt-4 mt-md-0">
                                                    <img id="showImage" class="rounded img-thumbnail w-100 h-100"
                                                        src="" data-holder-rendered="true">
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
                                        <x-input-label for="icon" :value="__('Icon')" class="form-label" />

                                        <div class="d-flex flex-column align-items-center gap-3">
                                            <div id="icon-preview" class="d-none">
                                                <div class="mt-4 mt-md-0">
                                                    <img id="showIcon" class="rounded img-thumbnail w-100 h-100"
                                                        src="" data-holder-rendered="true">
                                                </div>
                                            </div>
                                            <div class="input-group">
                                                <input type="file" id="icon" name="icon" class="form-control"
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


                            <section class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title">Your Awards</h4>

                                            <div class="table-responsive">
                                                <table class="table table-editable table-nowrap align-middle table-edits">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Image</th>
                                                            <th>Icon</th>
                                                            <th>Title</th>
                                                            <th>Short Description</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($services as $service)
                                                            <tr>
                                                                <td style="width: 80px">{{ $service->id }}</td>
                                                                <td style="width: 100px">
                                                                    @if ($service->image != null)
                                                                        <img src="{{ $service->image && str_starts_with($service->image, 'defaults_images/') ? asset($service->image) : asset('storage/' . $service->image) }}"
                                                                            alt="{{ $service->title }}" class="img-thumbnail"
                                                                            style="width: 100px">
                                                                    @else
                                                                        <span>No Image</span>
                                                                    @endif
                                                                </td>
                                                                <td style="width: 100px">
                                                                    @if ($service->icon != null)
                                                                        <img src="{{ $service->icon && str_starts_with($service->icon, 'defaults_images/') ? asset($service->icon) : asset('storage/' . $service->icon) }}"
                                                                            alt="{{ $service->title }}" class="img-thumbnail"
                                                                            style="width: 100px">
                                                                    @else
                                                                        <span>No Icon</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $service->title }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $service->short_description }}</span>
                                                                </td>
                                                                <td style="width: 100px">
                                                                    <a href="{{ route('service.edit', $service->id) }}"
                                                                        class="btn btn-outline-secondary btn-sm edit"
                                                                        title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form action="{{ route('service.destroy', $service) }}"
                                                                        method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <button type="submit"
                                                                            class="btn btn-outline-danger btn-sm delete"
                                                                            title="Delete">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
