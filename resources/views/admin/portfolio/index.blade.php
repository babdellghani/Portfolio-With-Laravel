@extends('admin.partials.master')
@section('title', 'Portfolio')

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
                                        {{ __('Portfolio Information') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Create and Update your Portfolio Information') }}
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


                                <form method="post" id="form" action="{{ route('portfolio.store') }}" class="mt-4"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <x-input-label for="title" :value="__('Title')" class="form-label" />
                                            <x-text-input id="title" name="title" type="text" class="form-control"
                                                :value="old('title')" placeholder="Title" required autofocus
                                                autocomplete="title" />
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('title')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="slug" :value="__('Slug')" class="form-label" />
                                            <x-text-input id="slug" name="slug" type="text" class="form-control"
                                                :value="old('slug')" placeholder="Slug" required autocomplete="slug" />
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('slug')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="date" :value="__('Date')" class="form-label" />
                                            <x-text-input id="date" name="date" type="date" class="form-control"
                                                :value="old('date')" placeholder="Date" required autocomplete="date" />
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('date')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="location" :value="__('Location')" class="form-label" />
                                            <x-text-input id="location" name="location" type="text" class="form-control"
                                                :value="old('location')" placeholder="Location" required
                                                autocomplete="location" />
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('location')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="client" :value="__('Client Name')" class="form-label" />
                                            <x-text-input id="client" name="client" type="text" class="form-control"
                                                :value="old('client')" placeholder="Client Name" required
                                                autocomplete="client" />
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('client')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="link" :value="__('Location')" class="form-label" />
                                            <x-text-input id="link" name="link" type="url" class="form-control"
                                                :value="old('link')" placeholder="https://example.com" required
                                                autocomplete="url" />
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('link')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="short_description" :value="__('Short Description')"
                                                class="form-label" />
                                            <x-textarea id="short_description" name="short_description" type="text"
                                                class="form-control" placeholder="Short Description" required
                                                autocomplete="description">{{ old('short_description') }}</x-textarea>
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('short_description')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="description" :value="__('Description')"
                                                class="form-label" />
                                            <textarea id="elm1" name="description">{{ old('description') }}</textarea>
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('description')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="square-switch" :value="__('Status')" class="form-label" />
                                            <div class="square-switch">
                                                <input type="checkbox" id="square-switch3" switch="bool" value="1"
                                                    name="status" @checked(old('status')) />
                                                <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('status')" />
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="category" :value="__('Category')" class="form-label" />
                                            <x-text-input id="category" name="category" type="text" class="form-control"
                                                :value="old('category')"
                                                placeholder="Enter categories separated by commas (e.g., Web Design, Mobile App)"
                                                required autocomplete="category" />
                                            <x-input-error class="text-danger small mt-1"
                                                :messages="$errors->get('category')" />
                                            <small class="form-text text-muted">Enter multiple categories separated by
                                                commas</small>
                                        </div>

                                        <div class="mb-3">
                                            <x-input-label for="image" :value="__('Image')" class="form-label" />
                                            <div class="d-flex flex-column align-items-center gap-3">
                                                <div id="image-preview" class="d-none">
                                                    <div class="mt-4 mt-md-0">
                                                        <img id="showImage" class="rounded img-thumbnail w-100 h-100" src=""
                                                            data-holder-rendered="true">
                                                    </div>
                                                </div>
                                                <div class="input-group flex-column gap-3">
                                                    <input type="file" id="image" name="image" class="form-control w-100"
                                                        id="customFile">
                                                    <x-input-error class="text-danger small mt-1"
                                                        :messages="$errors->get('image')" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-3">
                                        <x-primary-button type="submit"
                                            class="btn btn-primary">{{ __('Save') }}</x-primary-button>
                                    </div>
                                </form>



                            </section>


                            <section class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">

                                            <h4 class="card-title">Your Portfolios</h4>

                                            <div class="table-responsive">
                                                <table class="table table-editable table-nowrap align-middle table-edits">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Image</th>
                                                            <th>Title</th>
                                                            <th>Short Description</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($portfolios as $portfolio)
                                                            <tr>
                                                                <td style="width: 80px">{{ $portfolio->id }}</td>
                                                                <td style="width: 100px">
                                                                    @if ($portfolio->image != null)
                                                                        <img src="{{ $portfolio->image && str_starts_with($portfolio->image, 'defaults_images/') ? asset($portfolio->image) : asset('storage/' . $portfolio->image) }}"
                                                                            alt="{{ $portfolio->title }}" class="img-thumbnail"
                                                                            style="width: 100px">
                                                                    @else
                                                                        <span>No Image</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $portfolio->title }}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="display">{{ $portfolio->short_description }}</span>
                                                                </td>
                                                                <td>
                                                                    <div class="square-switch">
                                                                        <form method="post" class="d-flex align-items-center"
                                                                            action="{{ route('portfolio.status', $portfolio) }}">
                                                                            @csrf
                                                                            @method('patch')
                                                                            <input type="hidden" name="status" value="0" />
                                                                            <input type="checkbox"
                                                                                id="square-switch3-{{ $portfolio->id }}"
                                                                                switch="bool" name="status" value="1"
                                                                                @checked($portfolio->status)
                                                                                onchange="this.form.submit()" />
                                                                            <label style="margin-bottom: 0% !important;"
                                                                                for="square-switch3-{{ $portfolio->id }}"
                                                                                data-on-label="Yes" data-off-label="No"
                                                                                onclick="document.getElementById('square-switch3-{{ $portfolio->id }}').click()"></label>
                                                                        </form>
                                                                    </div>
                                                                </td>
                                                                <td style="width: 100px">
                                                                    <a href="{{ route('portfolio.edit', $portfolio->id) }}"
                                                                        class="btn btn-outline-secondary btn-sm edit"
                                                                        title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form action="{{ route('portfolio.destroy', $portfolio) }}"
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
                                                        @empty
                                                            <tr>
                                                                <td colspan="6" class="text-center">No Data Found</td>
                                                            </tr>
                                                        @endforelse
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
            $(document).ready(function () {
                $('#image').change(function () {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#showImage').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);

                    $('#image-preview').removeClass('d-none');
                });

                $('#icon').change(function () {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#showIcon').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);

                    $('#icon-preview').removeClass('d-none');
                });
            });
        </script>
    @endpush

@endsection