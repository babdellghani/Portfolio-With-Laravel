@extends('admin.partials.master')
@section('title', 'Skills')

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8" style="width: 100% !important;">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            <section>

                                <header>
                                    <a href="{{ route('skill') }}" class="btn btn-secondary mb-3">
                                        {{ __('Back to List') }}
                                    </a>

                                    <h2 class="fs-4 fw-medium text-dark">
                                        {{ __('Skills Information') }}
                                    </h2>

                                    <p class="mt-1 text-muted small">
                                        {{ __('Update your Skills Information') }}
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

                                <form method="post" action="{{ route('skill.update', $skill) }}" class="mt-4"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('put')

                                    <div class="mb-3">
                                        <x-input-label for="name" :value="__('Name')" class="form-label" />
                                        <x-text-input id="name" name="name" type="text" class="form-control"
                                            :value="old('name', $skill->name)" placeholder="Name" required autofocus autocomplete="name" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="range_01" :value="__('Value')" class="form-label" />
                                        <x-text-input type="number" placeholder="Value" id="range_01" name="value"
                                            :value="old('value', $skill->value)" max="100" min="0" required/>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('value')" />
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
@endsection
