@extends('admin.partials.master')
@section('title', 'My Messages')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">My Messages</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">My Messages</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Contact Messages</h4>
                        <p class="text-muted mb-0">View all your contact messages and admin replies</p>
                    </div>
                    <div class="card-body">
                        @if ($contacts->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Reply Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr class="{{ ($contact->is_replied || $contact->replies->count() > 0) ? 'table-success' : ($contact->is_read ? 'table-warning' : 'table-light') }}">
                                                <td>{{ $contact->id }}</td>
                                                <td>
                                                    <strong>Contact from {{ $contact->name }}</strong>
                                                </td>
                                                <td>
                                                    {{ Str::limit($contact->message, 50) }}
                                                </td>
                                                <td>
                                                    @if ($contact->is_read)
                                                        <span class="badge bg-success">Read</span>
                                                    @else
                                                        <span class="badge bg-warning">New</span>
                                                    @endif
                                                </td>
                                                <td>{{ $contact->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    @if ($contact->is_replied || $contact->replies->count() > 0)
                                                        <span class="badge bg-success">
                                                            <i class="ri-reply-line"></i> Replied
                                                        </span>
                                                        <small class="d-block text-muted">
                                                            @if($contact->replies->count() > 0)
                                                                {{ $contact->replies->last()->created_at->format('M d, Y H:i') }}
                                                                @if($contact->replies->count() > 1)
                                                                    <span class="badge bg-info ms-1">{{ $contact->replies->count() }} replies</span>
                                                                @endif
                                                            @else
                                                                {{ $contact->replied_at?->format('M d, Y H:i') }}
                                                            @endif
                                                        </small>
                                                    @else
                                                        <span class="badge bg-secondary">
                                                            <i class="ri-time-line"></i> Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ route('user.messages.show', $contact->id) }}"
                                                        class="btn btn-primary btn-sm">
                                                        <i class="ri-eye-line"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Pagination -->
                            <div class="d-flex justify-content-center">
                                {{ $contacts->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="ri-mail-line display-4 text-muted"></i>
                                <h5 class="mt-3 text-muted">No Messages Found</h5>
                                <p class="text-muted">You haven't sent any contact messages yet.</p>
                                <a href="{{ route('contact-us') }}" class="btn btn-primary">
                                    <i class="ri-mail-send-line"></i> Send a Message
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
