@extends('admin.partials.master')
@section('title', 'Awards')

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
                                        {{ __('Award Information') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Create and Update your Award Information') }}
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

                                <form method="post" action="{{ route('award.store') }}" class="mt-4" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <x-input-label for="title" :value="__('Name')" class="form-label" />
                                        <x-text-input id="title" name="title" type="text" class="form-control"
                                            :value="old('title')" placeholder="Name" required autofocus autocomplete="name" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="year" :value="__('Year')" class="form-label" />
                                        <x-text-input id="year" name="year" type="number" class="form-control"
                                            :value="old('year')" placeholder="Year" required autocomplete="year" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('year')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="description" :value="__('Description')" class="form-label" />
                                        <x-textarea id="description" name="description" type="text" class="form-control"
                                            placeholder="Description" required
                                            autocomplete="description">{{ old('description') }}</x-textarea>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="image" :value="__('Award Image')" class="form-label" />

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
                                                            <th>Name</th>
                                                            <th>Year</th>
                                                            <th>Description</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($awards as $award)
                                                            <tr>
                                                                <td style="width: 80px">{{ $award->id }}</td>
                                                                <td style="width: 100px">
                                                                    @if ($award->image != null)
                                                                        <img src="{{ asset('storage/' . $award->image) }}"
                                                                            alt="{{ $award->title }}" class="img-thumbnail"
                                                                            style="width: 100px">
                                                                    @else
                                                                        <span>No Image</span>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $award->title }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $award->year }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $award->description }}</span>
                                                                </td>
                                                                <td style="width: 100px">
                                                                    <a href="{{ route('award.edit', $award->id) }}"
                                                                        class="btn btn-outline-secondary btn-sm edit"
                                                                        title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form action="{{ route('award.destroy', $award) }}"
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
