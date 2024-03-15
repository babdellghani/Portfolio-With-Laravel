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

                                <form method="post" action="{{ route('award.store') }}" class="mt-4">
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
                                        <x-textarea id="description" name="description" type="text" class="form-control" placeholder="Description" required
                                            autocomplete="description">{{ old('description') }}</x-textarea>
                                        <x-input-error class="text-danger small mt-1" :messages="$errors->get('description')" />
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

@endsection
