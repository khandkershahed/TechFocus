@extends('admin.master')
@section('content')
<div class="container-fluid h-100">
    <div class="row">
        <div class="col-lg-12">
            <div class="card my-5 rounded-0 shadow-sm">

                {{-- Card Header --}}
                <div class="main_bg card-header py-2 d-flex justify-content-between align-items-center">
                    <a class="btn btn-sm btn-primary btn-rounded rounded-circle btn-icon" href="{{ URL::previous() }}">
                        <i class="fa-solid fa-arrow-left text-white"></i>
                    </a>
                    <h4 class="text-white fw-bold m-0">Employee Task Management</h4>
                </div>

                {{-- Card Body --}}
                <div class="card-body">

                    {{-- Add New Task Button --}}
                    <div class="row mb-3">
                        <div class="col-lg-12 text-end">
                            @if($selectedEmployeeId)
                            <a href="{{ route('admin.employee-task.create') }}?employee_id={{ $selectedEmployeeId }}" 
                               class="btn btn-sm btn-primary">
                                <i class="fa-solid fa-plus"></i> Add New Task
                            </a>
                            @else

                            
                            <button class="btn btn-sm btn-primary" disabled>
                                <i class="fa-solid fa-plus"></i> Add New Task
                            </button>
                            @endif
                        </div>
                    </div>

                    {{-- Employee Selection --}}
                    <div class="row mb-4">
                        <div class="col-lg-4 offset-lg-4">
                            <label class="form-label required">Select Employee</label>
                            <select class="form-select form-select-sm form-select-solid" id="selectEmployee">
                                <option value="">-- Select Employee --</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" 
                                        {{ $selectedEmployeeId == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Task Table --}}
                    <div class="monthly_task_table">
                        @if(!$selectedEmployeeId)
                            <div class="text-center text-muted py-4">Select an employee to view tasks.</div>
                        @elseif($tasks->isEmpty())
                            <div class="text-center text-muted py-4">No tasks found for this employee.</div>
                        @else
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>Task Name</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                    <tr>
                                        <td>{{ $task->task_name }}</td>
                                        <td>{{ $task->start_date }}</td>
                                        <td>{{ $task->end_date }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-primary editTaskBtn" data-id="{{ $task->id }}">Edit</button>
                                            <button class="btn btn-sm btn-danger deleteTaskBtn" data-id="{{ $task->id }}">Delete</button>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Edit Task Modal --}}
<div class="modal fade" id="taskEditModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-0 border-0 shadow-sm">
            <div class="modal-header p-2">
                <h5 class="modal-title">Edit Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editTaskForm">
                @csrf
                <input type="hidden" name="task_id" id="editTaskId">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Task Name</label>
                        <input type="text" name="task_name" id="editTaskName" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Start Date</label>
                        <input type="date" name="start_date" id="editStartDate" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">End Date</label>
                        <input type="date" name="end_date" id="editEndDate" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="modal-footer p-2">
                    <button type="submit" class="btn btn-sm btn-light-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function(){
    // Load tasks for selected employee
    function loadTasks(employeeId){
        if(!employeeId){
            $('.monthly_task_table').html('<div class="text-center text-muted py-4">Select an employee to view tasks.</div>');
            return;
        }

        // Show loading
        $('.monthly_task_table').html('<div class="text-center text-muted py-4">Loading tasks...</div>');

        // Update URL without page reload
        const url = new URL(window.location);
        url.searchParams.set('employee_id', employeeId);
        window.history.pushState({}, '', url);

        $.ajax({
            url: '/admin/employee-task',
            type: 'GET',
            data: {
                employee_id: employeeId,
                ajax: true
            },
            success: function(res){
                // Check if response has html property
                if (res && res.html) {
                    $('.monthly_task_table').html(res.html);
                } else {
                    // If it's the full page, try to extract the task table
                    console.log('Unexpected response format:', res);
                    $('.monthly_task_table').html('<div class="text-center text-danger py-4">Error: Unexpected response format</div>');
                }
            },
            error: function(xhr) {
                console.error('Error loading tasks:', xhr);
                $('.monthly_task_table').html('<div class="text-center text-danger py-4">Error loading tasks. Please try again.</div>');
            }
        });
    }

    // Employee selection change
    $('#selectEmployee').change(function(){
        const employeeId = $(this).val();
        loadTasks(employeeId);
    });

    // Edit Task
    $(document).on('click', '.editTaskBtn', function(){
        const id = $(this).data('id');
        $.get('/admin/employee-task/'+id+'/edit', function(task){
            $('#editTaskId').val(task.id);
            $('#editTaskName').val(task.task_name);
            $('#editStartDate').val(task.start_date);
            $('#editEndDate').val(task.end_date);
            $('#taskEditModal').modal('show');
        }).fail(function() {
            toastr.error('Error loading task data');
        });
    });

    // Update Task
    $('#editTaskForm').submit(function(e){
        e.preventDefault();
        const id = $('#editTaskId').val();
        const empId = $('#selectEmployee').val();
        
        $.ajax({
            url: '/admin/employee-task/'+id,
            type: 'POST',
            data: $(this).serialize()+'&_method=PUT',
            success: function(res){
                if(res.success){
                    $('#taskEditModal').modal('hide');
                    loadTasks(empId);
                    toastr.success(res.message);
                }
            },
            error: function(xhr) {
                toastr.error('Error updating task');
                console.error(xhr.responseText);
            }
        });
    });

    // Delete Task
    
// Delete Task
$(document).on('click', '.deleteTaskBtn', function(){
    if(!confirm('Are you sure you want to delete this task?')) return;
    const id = $(this).data('id');
    const empId = $('#selectEmployee').val();
    
    $.ajax({
        url: '/admin/employee-task/' + id, // Remove /delete from the URL
        type: 'POST',
        data: {
            _method: 'DELETE', 
            _token: '{{ csrf_token() }}'
        },
        success: function(res){
            if(res.success){
                loadTasks(empId);
                toastr.success(res.message);
            } else {
                toastr.error(res.message || 'Failed to delete task');
            }
        },
        error: function(xhr) {
            console.error('Delete error:', xhr);
            if(xhr.status === 404) {
                toastr.error('Task not found');
            } else if(xhr.status === 500) {
                toastr.error('Server error occurred');
            } else {
                toastr.error('Error deleting task');
            }
        }
    });
});
    // Auto-refresh tasks when coming back from create page
    @if($selectedEmployeeId && session('success'))
        toastr.success('{{ session('success') }}');
        // Reload tasks to show newly created ones
        setTimeout(function() {
            loadTasks({{ $selectedEmployeeId }});
        }, 500);
    @endif

    // Also reload tasks on page load if employee is selected (to ensure fresh data)
    @if($selectedEmployeeId)
        setTimeout(function() {
            loadTasks({{ $selectedEmployeeId }});
        }, 1000);
    @endif

});
</script>
@endpush