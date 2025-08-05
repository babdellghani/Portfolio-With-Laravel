@extends('admin.partials.master')
@section('title', 'User Details')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">User Details</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active">{{ $user->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-4">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}"
                                    class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3"
                                    style="width: 80px; height: 80px;">
                                    <span class="text-white fw-bold fs-2">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif
                            <div>
                                <h4 class="mb-1">{{ $user->name }}</h4>
                                <p class="text-muted mb-1">{{ $user->email }}</p>
                                <div class="d-flex gap-2">
                                    <span class="badge {{ $user->getRoleBadgeClass() }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                    <span class="badge {{ $user->getStatusBadgeClass() }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <h5>Personal Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Full Name:</td>
                                        <td>{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Username:</td>
                                        <td>{{ $user->username }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email:</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Email Verified:</td>
                                        <td>
                                            @if ($user->email_verified_at)
                                                <span class="badge badge-soft-success">
                                                    {{ $user->email_verified_at->format('M d, Y H:i') }}
                                                </span>
                                            @else
                                                <span class="badge badge-soft-warning">Not Verified</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <h5>Account Information</h5>
                                <table class="table table-borderless">
                                    <tr>
                                        <td class="fw-bold">Role:</td>
                                        <td>
                                            <span class="badge {{ $user->getRoleBadgeClass() }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Status:</td>
                                        <td>
                                            <span class="badge {{ $user->getStatusBadgeClass() }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Created:</td>
                                        <td>{{ $user->created_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Last Updated:</td>
                                        <td>{{ $user->updated_at->format('M d, Y H:i') }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Quick Actions</h5>
                        <div class="d-grid gap-2">
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">
                                <i class="bx bx-edit"></i> Edit User
                            </a>

                            <form method="POST" action="{{ route('users.toggle-status', $user) }}" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit"
                                    class="btn btn-{{ $user->isActive() ? 'warning' : 'success' }} w-100">
                                    <i class="bx bx-{{ $user->isActive() ? 'pause' : 'play' }}"></i>
                                    {{ $user->isActive() ? 'Deactivate' : 'Activate' }} User
                                </button>
                            </form>

                            @if (auth()->id() !== $user->id)
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bx bx-trash"></i> Delete User
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-info">
                                    <small>You cannot delete your own account</small>
                                </div>
                            @endif

                            <a href="{{ route('users.index') }}" class="btn btn-secondary w-100">
                                <i class="bx bx-arrow-back"></i> Back to Users
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <h5 class="card-title">Account Statistics</h5>
                        <div class="text-center">
                            <div class="mb-3">
                                <h4 class="text-primary">{{ $user->id }}</h4>
                                <p class="text-muted mb-0">User ID</p>
                            </div>
                            <div class="mb-3">
                                <h4 class="text-info">{{ $user->created_at->diffForHumans() }}</h4>
                                <p class="text-muted mb-0">Member Since</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
