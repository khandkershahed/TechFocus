@extends('admin.master')

@section('title', 'Contact Details')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Contact Message Details</h1>
        <a href="{{ route('admin.pages.contact.index') }}" class="btn btn-secondary">Back to List</a>
    </div>

    <!-- Display success/error messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Display validation errors -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Contact Information</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Code:</th>
                            <td>{{ $contact->code }}</td>
                        </tr>
                        <tr>
                            <th>Name:</th>
                            <td>{{ $contact->name }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $contact->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone:</th>
                            <td>{{ $contact->phone ?? 'N/A' }}</td>
                        </tr>
                        {{-- <tr>
                            <th>Status:</th>
                            <td>
                                @if($contact->status === 'replied')
                                    <span class="badge bg-success">Replied</span>
                                @else
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @endif
                            </td>
                        </tr> --}}
                        <tr>
                            <th>Date:</th>
                            <td>{{ $contact->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        @if($contact->replied_at)
                        <tr>
                            <th>Replied At:</th>
                            <td>{{ $contact->replied_at->format('d M Y H:i') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Original Message</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted" style="white-space: pre-line;">{{ $contact->message }}</p>
                </div>
            </div>

            {{-- @if($contact->reply_message)
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Your Reply</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted" style="white-space: pre-line;">{{ $contact->reply_message }}</p>
                    <small class="text-muted">
                        Replied on: {{ $contact->updated_at->format('d M Y H:i') }}
                        @if($contact->replied_at)
                            ({{ $contact->replied_at->format('d M Y H:i') }})
                        @endif
                    </small>
                </div>
            </div>
            @endif
        </div> --}}
    </div>

    {{-- <!-- Reply Form -->
    @if($contact->status !== 'replied')
    <div class="card shadow-sm mt-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Send Reply</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.pages.contact.update', $contact->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="reply_message" class="form-label">Reply Message <span class="text-danger">*</span></label>
                    <textarea name="reply_message" id="reply_message" rows="6" 
                              class="form-control @error('reply_message') is-invalid @enderror" 
                              placeholder="Type your reply message here (minimum 10 characters)..." 
                              required>{{ old('reply_message') }}</textarea>
                    @error('reply_message')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">Minimum 10 characters required.</div>
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-paper-plane me-2"></i>Send Reply
                    </button>
                    
                    <form action="{{ route('admin.pages.contact.destroy', $contact->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" 
                                onclick="return confirm('Are you sure you want to delete this contact? This action cannot be undone.')">
                            <i class="fas fa-trash me-2"></i>Delete Contact
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
    @else
    <div class="card shadow-sm mt-4">
        <div class="card-body text-center">
            <p class="text-success mb-3">
                <i class="fas fa-check-circle fa-2x"></i><br>
                You have already replied to this message on {{ $contact->updated_at->format('d M Y H:i') }}.
            </p>
            <form action="{{ route('admin.pages.contact.destroy', $contact->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" 
                        onclick="return confirm('Are you sure you want to delete this contact? This action cannot be undone.')">
                    <i class="fas fa-trash me-2"></i>Delete Contact
                </button>
            </form>
        </div>
    </div>
    @endif
</div> --}}
@endsection

@section('styles')
<style>
    .table-borderless th {
        font-weight: 600;
    }
    .card {
        border: none;
        border-radius: 10px;
    }
    .card-header {
        border-radius: 10px 10px 0 0 !important;
    }
    .alert {
        border-radius: 10px;
        border: none;
    }
</style>
@endsection