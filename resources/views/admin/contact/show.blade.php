@extends('admin.partials.master')
@section('title', 'View Message - ' . $contact->name)

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Message from {{ $contact->name }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('contact') }}">Messages</a></li>
                            <li class="breadcrumb-item active">{{ $contact->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <!-- Message Details -->
            <div class="col-lg-8">
                <div class="card shadow-sm rounded">
                    <div class="card-header bg-light">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="ri-mail-line me-2"></i>
                                Contact Message Details
                            </h5>
                            <div>
                                @if (!$contact->is_read)
                                    <span class="badge bg-warning">Unread</span>
                                @endif
                                @if ($contact->is_replied)
                                    <span class="badge bg-success">Replied</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>From:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $contact->name }}
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Email:</strong>
                            </div>
                            <div class="col-sm-9">
                                <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                            </div>
                        </div>

                        @if ($contact->phone)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Phone:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                                </div>
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Received:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $contact->created_at->format('F j, Y \a\t g:i A') }}
                                <small class="text-muted">({{ $contact->created_at->diffForHumans() }})</small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Message:</strong>
                            </div>
                            <div class="col-sm-9">
                                <div class="bg-light p-3 rounded">
                                    {!! nl2br(e($contact->message)) !!}
                                </div>
                            </div>
                        </div>

                        @if ($contact->is_replied && $contact->admin_reply)
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <strong>Your Reply:</strong>
                                </div>
                                <div class="col-sm-9">
                                    <div class="bg-success bg-opacity-10 p-3 rounded border-start border-success border-3">
                                        {!! nl2br(e($contact->admin_reply)) !!}
                                    </div>
                                    <small class="text-muted">
                                        Replied on
                                        {{ $contact->replied_at ? $contact->replied_at->format('F j, Y \a\t g:i A') : 'Unknown' }}
                                    </small>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions Panel -->
            <div class="col-lg-4">
                <div class="card shadow-sm rounded">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">
                            <i class="ri-tools-line me-2"></i>
                            Actions
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <!-- Mark as Read/Unread -->
                            @if (!$contact->is_read)
                                <button type="button" class="btn btn-outline-info" id="markReadBtn">
                                    <i class="ri-check-line me-2"></i>
                                    Mark as Read
                                </button>
                            @endif

                            <!-- Reply Button -->
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                data-bs-target="#replyModal">
                                <i class="ri-reply-line me-2"></i>
                                {{ $contact->is_replied ? 'Send Another Reply' : 'Reply to Message' }}
                            </button>

                            <!-- Back to Messages -->
                            <a href="{{ route('contact') }}" class="btn btn-outline-secondary">
                                <i class="ri-arrow-left-line me-2"></i>
                                Back to Messages
                            </a>

                            <!-- Delete -->
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                data-bs-target="#deleteModal">
                                <i class="ri-delete-bin-line me-2"></i>
                                Delete Message
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Contact Info Card -->
                <div class="card shadow-sm rounded mt-3">
                    <div class="card-header bg-light">
                        <h6 class="card-title mb-0">
                            <i class="ri-user-line me-2"></i>
                            Contact Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <div
                                class="avatar-lg mx-auto mb-3 bg-primary rounded-circle d-flex align-items-center justify-content-center">
                                <i class="ri-user-line text-white" style="font-size: 2rem;"></i>
                            </div>
                            <h5 class="mb-1">{{ $contact->name }}</h5>
                            <p class="text-muted mb-0">{{ $contact->email }}</p>
                            @if ($contact->phone)
                                <p class="text-muted">{{ $contact->phone }}</p>
                            @endif
                        </div>

                        <div class="d-grid gap-2">
                            <a href="mailto:{{ $contact->email }}" class="btn btn-sm btn-outline-primary">
                                <i class="ri-mail-line me-2"></i>
                                Send Email
                            </a>
                            @if ($contact->phone)
                                <a href="tel:{{ $contact->phone }}" class="btn btn-sm btn-outline-success">
                                    <i class="ri-phone-line me-2"></i>
                                    Call Now
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form method="POST" action="{{ route('contact.reply', $contact) }}">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Reply to {{ $contact->name }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="replyMessage" class="form-label">Your Reply Message *</label>
                            <textarea name="admin_reply" id="replyMessage" class="form-control" rows="6" required
                                placeholder="Type your reply message here...">{{ old('admin_reply') }}</textarea>
                            @error('admin_reply')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="ri-information-line me-2"></i>
                            <strong>Note:</strong> This reply will be sent to {{ $contact->email }} and saved in the
                            system.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="ri-send-plane-line me-2"></i>
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this message from <strong>{{ $contact->name }}</strong>?</p>
                    <p class="text-danger"><small>This action cannot be undone.</small></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('contact.destroy', $contact) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                toastr.success('{{ session('success') }}');
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @foreach ($errors->all() as $error)
                    toastr.error('{{ $error }}');
                @endforeach
            });
        </script>
    @endif

    <script>
        // Mark as read functionality
        @if (!$contact->is_read)
            document.getElementById('markReadBtn').addEventListener('click', function() {
                fetch(`/admin/contacts/{{ $contact->id }}/mark-read`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        @endif
    </script>
@endsection
