@extends('admin.partials.master')
@section('title', 'Skills')

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

                                <form method="post" action="{{ route('skill.store') }}" class="mt-4">
                                    @csrf

                                    <div class="mb-3">
                                        <x-input-label for="name" :value="__('Name')" class="form-label" />
                                        <x-text-input id="name" name="name" type="text" class="form-control"
                                            :value="old('name')" placeholder="Name" required autofocus autocomplete="name" />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                                    </div>

                                    <div class="mb-3">
                                        <x-input-label for="range_01" :value="__('Value')" class="form-label" />
                                        <x-text-input type="number" placeholder="Value" id="range_01" name="value" :value="old('value')"
                                            max="100" min="0" required />
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('value')" />
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

                                            <h4 class="card-title">Your Skills</h4>

                                            <div class="table-responsive">
                                                <table class="table table-editable table-nowrap align-middle table-edits">
                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Name</th>
                                                            <th>Value</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($skills as $skill)
                                                            <tr>
                                                                <td style="width: 80px">{{ $skill->id }}</td>
                                                                <td>
                                                                    <span class="display">{{ $skill->name }}</span>
                                                                </td>
                                                                <td>
                                                                    <span
                                                                        class="display">{{ $skill->value }}</span>
                                                                </td>
                                                                <td style="width: 100px">
                                                                    <a href="{{ route('skill.edit', $skill->id) }}"
                                                                        class="btn btn-outline-secondary btn-sm edit"
                                                                        title="Edit">
                                                                        <i class="fas fa-pencil-alt"></i>
                                                                    </a>
                                                                    <form
                                                                        action="{{ route('skill.destroy', $skill) }}"
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
@endsection
