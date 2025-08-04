@extends('admin.partials.master')
@section('title', 'Contact Messages')

@section('content')
    <div class="container-fluid">
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">
                        Contact Messages
                        @if ($unreadCount > 0)
                            <span class="badge bg-danger">{{ $unreadCount }} Unread</span>
                        @endif
                    </h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Messages</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm rounded">
                    <div class="card-body">
                        <section class="mb-4">
                            <header class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="fs-4 fw-medium text-dark">
                                        {{ __('Contact Messages') }}
                                    </h2>
                                    <p class="mt-1 text-muted small">
                                        {{ __('Manage contact form submissions and replies') }}
                                    </p>
                                </div>
                                <div>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="filterMessages('all')">
                                            All ({{ $contacts->count() }})
                                        </button>
                                        <button type="button" class="btn btn-outline-warning btn-sm"
                                            onclick="filterMessages('unread')">
                                            Unread ({{ $unreadCount }})
                                        </button>
                                        <button type="button" class="btn btn-outline-success btn-sm"
                                            onclick="filterMessages('replied')">
                                            Replied ({{ $contacts->where('is_replied', true)->count() }})
                                        </button>
                                    </div>
                                </div>
                            </header>

                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <div class="table-responsive mt-4">
                                <table class="table table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="contactsTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Message</th>
                                            <th>Status</th>
                                            <th>Received</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($contacts as $contact)
                                            <tr class="message-row"
                                                data-status="{{ $contact->is_read ? 'read' : 'unread' }} {{ $contact->is_replied ? 'replied' : 'not-replied' }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if (!$contact->is_read)
                                                            <i class="ri-mail-line text-primary me-2"></i>
                                                        @else
                                                            <i class="ri-mail-open-line text-muted me-2"></i>
                                                        @endif
                                                        <strong class="{{ !$contact->is_read ? 'text-primary' : '' }}">
                                                            {{ $contact->name }}
                                                        </strong>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="mailto:{{ $contact->email }}" class="text-decoration-none">
                                                        {{ $contact->email }}
                                                    </a>
                                                </td>
                                                <td>
                                                    @if ($contact->phone)
                                                        <a href="tel:{{ $contact->phone }}" class="text-decoration-none">
                                                            {{ $contact->phone }}
                                                        </a>
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="message-preview">
                                                        {{ Str::limit($contact->message, 60) }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        @if (!$contact->is_read)
                                                            <span class="badge bg-warning mb-1">Unread</span>
                                                        @else
                                                            <span class="badge bg-secondary mb-1">Read</span>
                                                        @endif

                                                        @if ($contact->is_replied)
                                                            <span class="badge bg-success">Replied</span>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $contact->created_at->format('M j, Y') }}<br>
                                                        {{ $contact->created_at->format('g:i A') }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('contact.show', $contact) }}"
                                                            class="btn btn-outline-primary btn-sm" title="View Message">
                                                            <i class="ri-eye-line"></i>
                                                        </a>

                                                        @if (!$contact->is_read)
                                                            <button type="button"
                                                                class="btn btn-outline-info btn-sm mark-read-btn"
                                                                data-contact-id="{{ $contact->id }}" title="Mark as Read">
                                                                <i class="ri-check-line"></i>
                                                            </button>
                                                        @endif

                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm delete-btn"
                                                            data-contact-id="{{ $contact->id }}" title="Delete Message">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4">
                                                    <div class="text-muted">
                                                        <i class="ri-mail-line" style="font-size: 2rem;"></i>
                                                        <p class="mt-2">No contact messages yet.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
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
                    <p>Are you sure you want to delete this contact message? This action cannot be undone.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Message</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Filter functionality
        function filterMessages(filter) {
            const rows = document.querySelectorAll('.message-row');

            rows.forEach(row => {
                const status = row.dataset.status;
                let show = false;

                switch (filter) {
                    case 'all':
                        show = true;
                        break;
                    case 'unread':
                        show = status.includes('unread');
                        break;
                    case 'replied':
                        show = status.includes('replied');
                        break;
                }

                row.style.display = show ? '' : 'none';
            });

            // Update button states
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            event.target.classList.add('active');
        }

        // Mark as read functionality
        document.querySelectorAll('.mark-read-btn').forEach(button => {
            button.addEventListener('click', function() {
                const contactId = this.dataset.contactId;

                fetch(`/admin/contacts/${contactId}/mark-read`, {
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
        });

        // Delete functionality
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const contactId = this.dataset.contactId;
                const deleteForm = document.getElementById('deleteForm');
                deleteForm.action = `/admin/contacts/${contactId}`;

                const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
                modal.show();
            });
        });

        // Initialize DataTable
        $(document).ready(function() {
            $('#contactsTable').DataTable({
                "order": [
                    [5, "desc"]
                ], // Sort by received date
                "pageLength": 25,
                "responsive": true
            });
        });
    </script>
@endsection
