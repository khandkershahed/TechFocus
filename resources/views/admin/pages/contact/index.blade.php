@extends('admin.master')

@section('title', 'Contact List')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Contact Messages</h1>

    <div class="card shadow-sm">
        <div class="card-body">

            <!-- Bulk Delete Form -->
            <form id="bulkDeleteForm" action="{{ route('admin.pages.contact.bulkDelete') }}" method="POST">
                @csrf
                @method('DELETE')

                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div>
                        <button type="submit" class="btn btn-danger btn-sm" id="deleteSelectedBtn" disabled>
                            <i class="fas fa-trash"></i> Delete Selected
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="deleteAllBtn">
                            <i class="fas fa-trash-alt"></i> Delete All
                        </button>
                    </div>
                    <span class="text-muted small">Total: {{ $contacts->count() }}</span>
                </div>

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th><input type="checkbox" id="selectAll"></th>
                            <th>#</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contacts as $contact)
                            <tr>
                                <td><input type="checkbox" name="ids[]" value="{{ $contact->id }}" class="contact-checkbox"></td>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contact->code }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ Str::limit($contact->message, 50) }}</td>
                                <td>{{ $contact->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.pages.contact.show', $contact->id) }}" 
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <form action="{{ route('admin.pages.contact.destroy', $contact->id) }}" 
                                          method="POST" 
                                          style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Are you sure you want to delete this contact?')">
                                            <i class="fas fa-trash me-1"></i>Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted">No contacts found!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // Select All Checkbox
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.contact-checkbox');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const deleteAllBtn = document.getElementById('deleteAllBtn');
    const bulkDeleteForm = document.getElementById('bulkDeleteForm');

    selectAll.addEventListener('change', function() {
        checkboxes.forEach(cb => cb.checked = this.checked);
        toggleDeleteButton();
    });

    checkboxes.forEach(cb => cb.addEventListener('change', toggleDeleteButton));

    function toggleDeleteButton() {
        const anyChecked = Array.from(checkboxes).some(cb => cb.checked);
        deleteSelectedBtn.disabled = !anyChecked;
    }

    // Confirm bulk delete
    bulkDeleteForm.addEventListener('submit', function(e) {
        if (!confirm('Are you sure you want to delete selected contacts?')) {
            e.preventDefault();
        }
    });

    // Delete all
    deleteAllBtn.addEventListener('click', function() {
        if (confirm('Are you sure you want to delete ALL contacts? This cannot be undone!')) {
            const form = document.createElement('form');
            form.action = "{{ route('admin.pages.contact.deleteAll') }}";
            form.method = "POST";
            form.innerHTML = `@csrf @method('DELETE')`;
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
@endpush
