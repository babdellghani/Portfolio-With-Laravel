@extends('admin.partials.master')
@section('title', 'Profile')

@section('content')
    <x-slot name="header">
        <h2 class="font-weight-bold h3 text-gray-800 mb-0">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 col-sm-8 offset-sm-2">
                    <div class="card shadow-sm rounded">
                        <div class="card-body">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection