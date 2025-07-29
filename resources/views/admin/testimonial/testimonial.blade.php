@extends('admin.partials.master')
@section('title', 'Testimonials')

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8" style="width: 100% !important;">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <section class="mb-4">

                                <header>
                                    <h2 class="fs-4 fw-medium text-dark">
                                        {{ __('Testimonial Information') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Create and Update your Testimonial Information') }}
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

                                <form method="post" action="{{ route('testimonial.store') }}" class="mt-4" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <x-input-label for="name" :value="__('Client Name')" class="form-label" />
                                        <x-text-input id="name" name="name" type="text" class="form-control"
                                            :value="old('name')" placeholder="Client Name" required autofocus autocomplete="name" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="title" :value="__('Client Title/Position')" class="form-label" />
                                        <x-text-input id="title" name="title" type="text" class="form-control"
                                            :value="old('title')" placeholder="e.g. CEO, Designer, etc." autocomplete="title" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('title')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="message" :value="__('Testimonial Message')" class="form-label" />
                                        <x-textarea id="message" name="message" type="text" class="form-control"
                                            placeholder="Testimonial Message" required rows="4"
                                            autocomplete="message">{{ old('message') }}</x-textarea>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('message')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="rating" :value="__('Rating')" class="form-label" />
                                        <select id="rating" name="rating" class="form-control" required>
                                            <option value="">Select Rating</option>
                                            <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 Stars</option>
                                            <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 Stars</option>
                                            <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 Stars</option>
                                            <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 Stars</option>
                                            <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 Star</option>
                                        </select>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('rating')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="image" :value="__('Client Image')" class="form-label" />

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
                                        <div class="form-check">
                                            <x-input-label for="square-switch" :value="__('Status')" class="form-label" />
                                            <div class="square-switch">
                                                <input type="checkbox" id="square-switch3" switch="bool" value="1" name="status" @checked(old('status', true)) />
                                                <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                            <x-input-error class="text-danger small mt-1" :messages="$errors->get('status')" />
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

                                            <h4 class="card-title">Your Testimonials</h4>

                                            <div class="table-responsive">
                                                <table class="table table-editable table-nowrap align-middle table-edits">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Image</th>
                                                            <th>Name</th>
                                                            <th>Title</th>
                                                            <th>Rating</th>
                                                            <th>Message</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($testimonials as $testimonial)
                                                            <tr>
                                                                <td style="width: 80px">{{ $testimonial->id }}</td>
                                                                <td style="width: 100px">
                                                                    @if ($testimonial->image != null)
                                                                        <img src="{{ $testimonial->image && str_starts_with($testimonial->image, 'defaults_images/') ? asset($testimonial->image) : asset('storage/' . $testimonial->image) }}"
                                                                            alt="{{ $testimonial->name }}" class="img-thumbnail rounded-circle"
                                                                            style="width: 60px; height: 60px; object-fit: cover;">
                                                                    @else
                                                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                                            <i class="fas fa-user text-white"></i>
                                                                        </div>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $testimonial->name }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ $testimonial->title ?? 'N/A' }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="display">
                                                                        @for ($i = 1; $i <= 5; $i++)
                                                                            @if ($i <= $testimonial->rating)
                                                                                <i class="fas fa-star text-warning"></i>
                                                                            @else
                                                                                <i class="far fa-star text-muted"></i>
                                                                            @endif
                                                                        @endfor
                                                                    </span>
                                                                </td>
                                                                <td>
                                                                    <span class="display">{{ Str::limit($testimonial->message, 50) }}</span>
                                                                </td>
                                                                <td>
                                                                    <form action="{{ route('testimonial.status', $testimonial) }}" method="post" class="d-inline">
                                                                        @csrf
                                                                        @method('patch')
                                                                        <button type="submit" class="btn btn-sm {{ $testimonial->status ? 'btn-success' : 'btn-secondary' }}">
                                                                            {{ $testimonial->status ? 'Active' : 'Inactive' }}
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                                <td style="width: 100px">
                                                                    <a href="{{ route('testimonial.edit', $testimonial->id) }}"
                                                                        class="btn btn-outline-secondary btn-sm edit"
                                                                        title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form action="{{ route('testimonial.destroy', $testimonial) }}"
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
