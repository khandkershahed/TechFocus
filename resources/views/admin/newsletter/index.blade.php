@extends('admin.master')

@section('content')
<div class="container mt-4">
    <h3>Newsletter Subscribers</h3>
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Email</th>
                <th>IP Address</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subscribers as $subscriber)
                <tr id="subscriberRow{{ $subscriber->id }}">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $subscriber->email }}</td>
                    <td>{{ $subscriber->ip_address }}</td>
                    <td>{{ $subscriber->created_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <button class="btn btn-danger btn-sm" onclick="deleteSubscriber({{ $subscriber->id }})">
                            Delete
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- jQuery and SweetAlert2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function deleteSubscriber(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will permanently delete the subscriber!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '/admin/newsletter/' + id, // route to destroy method
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    );
                    $('#subscriberRow' + id).remove(); // remove row from table
                },
                error: function(xhr) {
                    Swal.fire(
                        'Error!',
                        xhr.responseJSON.message || 'Something went wrong!',
                        'error'
                    );
                }
            });
        }
    });
}
</script>
@endsection
