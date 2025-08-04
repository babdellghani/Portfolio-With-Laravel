@extends('admin.partials.master')
@section('title', 'Education Information')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Edit Education</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('education') }}">Education</a></li>
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
                        <section>

                            <header>
                                <a href="{{ route('education') }}" class="btn btn-secondary mb-3">
                                    {{ __('Back to List') }}
                                </a>

                                <h2 class="fs-4 fw-medium text-dark">
                                    {{ __('Education Information') }}
                                </h2>

                                <p class="mt-1 text-muted small">
                                    {{ __('Update your Education Information') }}
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

                            <form method="post" action="{{ route('education.update', $education) }}" class="mt-4"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')

                                <div class="mb-3">
                                    <x-input-label for="name" :value="__('Name')" class="form-label" />
                                    <x-text-input id="name" name="name" type="text" class="form-control"
                                        :value="old('name', $education->name)" placeholder="Name" required autofocus autocomplete="name" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="description" :value="__('Description')" class="form-label" />
                                    <x-textarea id="description" name="description" type="text" class="form-control"
                                        placeholder="Description" required
                                        autocomplete="description">{{ old('description', $education->description) }}</x-textarea>
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="start_date" :value="__('Start Date')" class="form-label" />
                                    <x-text-input id="start_date" name="start_date" type="date" class="form-control"
                                        :value="old('start_date', $education->start_date)" placeholder="Start Date" required autocomplete="start_date" />
                                    <x-input-error class="text-danger small mt-1" :messages="$errors->get('start_date')" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="end_date" :value="__('End Date')" class="form-label" />
                                    <x-text-input id="end_date" name="end_date" type="date" class="form-control"
                                        :value="old('end_date', $education->end_date)" placeholder="End Date" required autocomplete="end_date" />
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
@endsection
