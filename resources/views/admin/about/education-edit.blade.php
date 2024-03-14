@extends('admin.partials.master')
@section('title', 'Education Information')

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
                                        {{ __('Education Information') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Update your Education Information') }}
                                    </p>
                                </header>

                                <form method="post" action="{{ route('about.store') }}" class="mt-4"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <x-input-label for="name" :value="__('Name')" class="form-label" />
                                        <x-text-input id="name" name="name" type="text" class="form-control"
                                            :value="old('name', $about->name)" placeholder="Name" required autofocus autocomplete="name" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="description" :value="__('Description')" class="form-label" />
                                        <x-text-input id="description" name="description" type="text"
                                            class="form-control" :value="old('description', $about->description)" placeholder="Description" required
                                            autocomplete="description" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="start_date" :value="__('Start Date')" class="form-label" />
                                        <x-text-input id="start_date" name="start_date" type="date" class="form-control"
                                            :value="old('start_date', $about->start_date)" placeholder="Start Date" required autocomplete="start_date" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('start_date')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="end_date" :value="__('End Date')" class="form-label" />
                                        <x-text-input id="end_date" name="end_date" type="date" class="form-control"
                                            :value="old('end_date', $about->end_date)" placeholder="End Date" required autocomplete="end_date" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('end_date')" />
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
    @endpush
@endsection
