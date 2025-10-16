@extends('admin.master')
@section('content')

<div class="container-fluid h-100">
    <div class="row">
        <div class="col-lg-12 card rounded-0 shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Employee Monthly Tasks</h4>
                <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#taskAddModal">
                    Add Task
                </button>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Select Employee</label>
                    <select name="employee_id" id="employeeSelect" class="form-select form-select-sm" data-control="select2">
                        <option value="">Select Employee</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="monthly_task_table">
                    {{-- Tasks will be loaded here via AJAX --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Add Task Modal --}}
<div class="modal fade" id="taskAddModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="addTaskForm" method="POST" action="{{ route('admin.employee-tasks.store') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="employee_id" id="hiddenEmployeeId">
                    <div class="mb-3">
                        <label class="form-label">Task Name</label>
                        <input type="text" name="task_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Task Modal --}}
<div class="modal fade" id="taskEditModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="editTaskForm" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="editTaskId">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Task Name</label>
                        <input type="text" name="task_name" id="editTaskName" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="editStartDate" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" id="editEndDate" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Load tasks when employee is selected
    $('#employeeSelect').change(function() {
        let employeeId = $(this).val();
        $('#hiddenEmployeeId').val(employeeId);

        if(!employeeId) return;

        $.get('/employee/monthly-tasks/' + employeeId, function(res) {
            if(res.success) $('.monthly_task_table').html(res.html);
        });
    });

    // Add task via AJAX
    $('#addTaskForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if(res.success) {
                    $('.monthly_task_table').html(res.html);
                    $('#taskAddModal').modal('hide');
                    toastr.success(res.message);
                }
            },
            error: function(xhr) {
                toastr.error('Error saving task');
                console.error(xhr.responseText);
            }
        });
    });

    // Edit task
    $(document).on('click', '.editTaskBtn', function() {
        let id = $(this).data('id');
        $.get('/admin/tasks/' + id + '/edit', function(res) {
            $('#editTaskId').val(res.id);
            $('#editTaskName').val(res.task_name);
            $('#editStartDate').val(res.start_date);
            $('#editEndDate').val(res.end_date);
            $('#editTaskForm').attr('action', '/admin/tasks/' + res.id);
            $('#taskEditModal').modal('show');
        });
    });

    // Update task
    $('#editTaskForm').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            success: function(res) {
                if(res.success) {
                    $('.monthly_task_table').html(res.html);
                    $('#taskEditModal').modal('hide');
                    toastr.success(res.message);
                }
            }
        });
    });

    // Delete task
    $(document).on('click', '.deleteTaskBtn', function() {
        let id = $(this).data('id');
        if(!confirm('Are you sure?')) return;

        $.ajax({
            url: '/admin/tasks/' + id,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(res) {
                if(res.success) {
                    $('.monthly_task_table').html(res.html);
                    toastr.success(res.message);
                }
            }
        });
    });
});
</script>
@endpush
