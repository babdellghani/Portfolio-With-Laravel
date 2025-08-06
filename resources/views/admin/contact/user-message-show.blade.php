@extends('admin.partials.master')
@section('title', 'Message Details')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Message Details</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('user.messages') }}">My Messages</a></li>
                            <li class="breadcrumb-item active">Message #{{ $contact->id }}</li>
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
                        <h4 class="card-title">Your Contact Message</h4>
                        <div class="d-flex align-items-center">
                            @if ($contact->is_replied && $contact->admin_reply)
                                <span class="badge bg-success me-2">
                                    <i class="ri-reply-line"></i> Admin Replied
                                </span>
                            @else
                                <span class="badge bg-warning me-2">
                                    <i class="ri-time-line"></i> Pending Reply
                                </span>
                            @endif

                            <a href="{{ route('user.messages') }}" class="btn btn-secondary btn-sm">
                                <i class="ri-arrow-left-line"></i> Back to Messages
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Original Message -->
                        <div class="border rounded p-3 mb-4 bg-light">
                            <h5 class="text-primary mb-3">
                                <i class="ri-mail-line"></i> Your Message
                            </h5>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Name:</strong> {{ $contact->name }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Email:</strong> {{ $contact->email }}
                                </div>
                            </div>

                            @if ($contact->phone)
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <strong>Phone:</strong> {{ $contact->phone }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Sent:</strong> {{ $contact->created_at->format('M d, Y \a\t H:i') }}
                                    </div>
                                </div>
                            @else
                                <div class="mb-3">
                                    <strong>Sent:</strong> {{ $contact->created_at->format('M d, Y \a\t H:i') }}
                                </div>
                            @endif

                            <div class="mb-0">
                                <strong>Message:</strong>
                                <div class="mt-2 p-2 border rounded bg-white">
                                    {{ $contact->message }}
                                </div>
                            </div>
                        </div>

                        <!-- Admin Replies -->
                        @if ($contact->is_replied && ($contact->admin_reply || $contact->replies->count() > 0))
                            <div class="border rounded p-3 mb-4 bg-success bg-opacity-10">
                                <h5 class="text-success mb-3">
                                    <i class="ri-customer-service-2-line"></i> Admin Replies
                                </h5>

                                {{-- Legacy single reply --}}
                                @if ($contact->admin_reply)
                                    <div class="mb-3 p-3 border rounded bg-white">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <strong>Admin Reply:</strong>
                                            <small class="text-muted">
                                                {{ $contact->replied_at?->format('M d, Y \a\t H:i') }}
                                            </small>
                                        </div>
                                        {!! nl2br(e($contact->admin_reply)) !!}
                                    </div>
                                @endif

                                {{-- New multiple replies --}}
                                @foreach ($contact->replies as $reply)
                                    <div class="mb-3 p-3 border rounded bg-white">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <strong>{{ $reply->admin->name }}:</strong>
                                            <small class="text-muted">
                                                {{ $reply->created_at->format('M d, Y \a\t H:i') }}
                                            </small>
                                        </div>
                                        {!! nl2br(e($reply->message)) !!}
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info">
                                <i class="ri-information-line"></i>
                                <strong>Waiting for Admin Reply</strong><br>
                                Your message has been received and is being processed. You will be notified when the admin
                                responds.
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="text-center">
                            @if (!$contact->is_replied)
                                <div class="alert alert-warning">
                                    <i class="ri-time-line"></i>
                                    We typically respond within 24-48 hours. Thank you for your patience!
                                </div>
                            @endif

                            <a href="{{ route('contact-us') }}" class="btn btn-primary">
                                <i class="ri-mail-send-line"></i> Send New Message
                            </a>

                            <a href="{{ route('user.messages') }}" class="btn btn-outline-secondary ms-2">
                                <i class="ri-arrow-left-line"></i> Back to All Messages
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
