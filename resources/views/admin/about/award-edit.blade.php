@extends('admin.partials.master')
@section('title', 'Award')

@section('content')
    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2">
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

                                <form method="post" action="{{ route('award.update', $award) }}" class="mt-4">
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
                                        <x-text-input id="description" name="description" type="text"
                                            class="form-control" :value="old('description', $award->description)" placeholder="Description" required
                                            autocomplete="description" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
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
