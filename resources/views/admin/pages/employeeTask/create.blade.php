@extends('admin.master')
@section('content')
<div class="container-fluid h-100">

    {{-- Toast Notification --}}
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055">
        <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body" id="successToastBody"></div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card my-5 rounded-0 shadow-sm">

                {{-- Card Header --}}
                <div class="main_bg card-header py-2 d-flex justify-content-between align-items-center">
                    <a class="btn btn-sm btn-primary btn-rounded rounded-circle btn-icon" href="{{ URL::previous() }}">
                        <i class="fa-solid fa-arrow-left text-white"></i>
                    </a>
                    <h4 class="text-white fw-bold m-0">Employee Monthly Target Set</h4>
                </div>

                {{-- Card Body --}}
                <div class="card-body">
                    <form id="employeeTaskForm" action="{{ route('admin.employee-task.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        {{-- Employee Selection --}}
                        <div class="row mb-5">
                            <div class="col-lg-4 offset-lg-4">
                                <label class="form-label required">Select Employee</label>
                                <select class="form-select form-select-solid form-select-sm" name="employee_id" required>
                                    <option value="">-- Select Employee --</option>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">Please select an employee.</div>
                            </div>
                        </div>

                        {{-- General Info --}}
                        <div class="row py-3 border p-4 mb-4 rounded-0">
                            <p class="badge badge-info rounded-0 mb-3">General Information</p>
                            <div class="row">
                                <div class="col-lg-4 mb-3">
                                    <label class="form-label">Title</label>
                                    <input name="title" type="text" class="form-control form-control-sm form-control-solid" placeholder="Task Title" required />
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label required">Fiscal Year</label>
                                    <select name="year" class="form-select form-select-solid form-select-sm" required>
                                        @php $currentYear = date('Y'); @endphp
                                        @for($y = $currentYear-10; $y <= $currentYear+10; $y++)
                                            <option value="{{ $y }}" @selected($y == $currentYear)>{{ $y }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-lg-3 mb-3">
                                    <label class="form-label required">Month</label>
                                    <select name="month" class="form-select form-select-solid form-select-sm" required>
                                        @foreach(range(1,12) as $m)
                                            <option value="{{ $m }}" @selected($m == date('n'))>{{ DateTime::createFromFormat('!m', $m)->format('F') }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 mb-3">
                                    <label class="form-label required">Quarter</label>
                                    <select name="quarter" class="form-select form-select-solid form-select-sm" required>
                                        <option value="q1">Quarter One</option>
                                        <option value="q2">Quarter Two</option>
                                        <option value="q3">Quarter Three</option>
                                        <option value="q4">Quarter Four</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- People Involved --}}
                        <div class="row py-3 border p-4 mb-4 rounded-0">
                            <p class="badge badge-info rounded-0 mb-3">People Involved</p>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label required">Supervisors</label>
                                <select name="supervisors[]" class="form-select form-select-solid form-select-sm" multiple required>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label required">Notify To</label>
                                <select name="notify_id[]" class="form-select form-select-solid form-select-sm" multiple required>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-lg-4 mb-3">
                                <label class="form-label required">Assignees / Standby</label>
                                <select name="assignees[]" class="form-select form-select-solid form-select-sm" multiple required>
                                    @foreach($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                       {{-- Task Repeater --}}


                       {{-- Task Repeater --}}
<div class="row py-3 border p-4 mb-4 rounded-0">
    <p class="badge badge-info rounded-0 mb-3">Tasks</p>
    <div id="kt_docs_repeater_advanced">
        <div data-repeater-list="kt_docs_repeater_advanced">
            <div data-repeater-item class="border p-3 mb-3 rounded-0">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label class="form-label required">Task Name</label>
                        <input type="text" name="task_name" class="form-control form-control-sm form-control-solid" required />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label required">Start Date</label>
                        <input type="date" name="start_date" class="form-control form-control-sm form-control-solid" required />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label required">End Date</label>
                        <input type="date" name="end_date" class="form-control form-control-sm form-control-solid" required />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Start Time</label>
                        <input type="time" name="start_time" class="form-control form-control-sm form-control-solid" />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">End Time</label>
                        <input type="time" name="end_time" class="form-control form-control-sm form-control-solid" />
                    </div>
                    <div class="col-md-1 text-center">
                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger">
                            <i class="fa-solid fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="row g-3 mt-2 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label">Buffer Time</label>
                        <input type="time" name="buffer_time" class="form-control form-control-sm form-control-solid" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" class="form-control form-control-sm form-control-solid" />
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Task Target</label>
                        <input type="text" name="task_target" class="form-control form-control-sm form-control-solid" />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Task Rating</label>
                        <input type="text" name="task_rating" class="form-control form-control-sm form-control-solid" />
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Task Weight</label>
                        <input type="number" name="task_weight" class="form-control form-control-sm form-control-solid" min="0" />
                    </div>
                </div>
                <div class="row g-3 mt-2">
                    <div class="col-md-12">
                        <label class="form-label">Task Description</label>
                        <textarea name="task_description" rows="2" class="form-control form-control-sm form-control-solid"></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-end mt-2">
            <a href="javascript:;" data-repeater-create class="btn btn-sm btn-success rounded-0">
                <i class="fa-solid fa-plus"></i> Add Task
            </a>
        </div>
    </div>
</div>
              {{-- Submit --}}
                        <div class="row">
                            <div class="col-lg-12 text-end">
                                <button type="submit" class="btn btn-primary btn-sm rounded-0">Submit</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function () {

    // Repeater initialization
    $('#kt_docs_repeater_advanced').repeater({
        initEmpty: false,
        show: function () { 
            $(this).slideDown();
            // Set default dates for new tasks
            const today = new Date().toISOString().split('T')[0];
            $(this).find('input[name="start_date"]').val(today);
            $(this).find('input[name="end_date"]').val(today);
        },
        hide: function (deleteElement) { $(this).slideUp(deleteElement); }
    });

    // Set default dates for first task
    const today = new Date().toISOString().split('T')[0];
    $('input[name="start_date"]').first().val(today);
    $('input[name="end_date"]').first().val(today);

    // CSRF token
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    // Format time to remove seconds
    function formatTime(timeString) {
        if (!timeString) return '';
        // If time is in HH:mm:ss format, remove seconds
        if (timeString.length > 5) {
            return timeString.substring(0, 5);
        }
        return timeString;
    }

    // AJAX form submit
    $('#employeeTaskForm').on('submit', function(e){
        e.preventDefault();
        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');
        let employeeId = $('select[name="employee_id"]').val();
        
        // Validate employee selection
        if (!employeeId) {
            toastr.error('Please select an employee');
            return;
        }

        submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin"></i> Submitting...');

        // Create FormData to handle repeater fields properly
        let formData = new FormData(this);

        // Add repeater data manually
        $('[data-repeater-item]').each(function(index) {
            let item = $(this);
            
            // Get all field values
            let taskName = item.find('input[name="task_name"]').val();
            let startDate = item.find('input[name="start_date"]').val();
            let endDate = item.find('input[name="end_date"]').val();
            let startTime = item.find('input[name="start_time"]').val();
            let endTime = item.find('input[name="end_time"]').val();
            let bufferTime = item.find('input[name="buffer_time"]').val();
            let location = item.find('input[name="location"]').val();
            let taskDescription = item.find('textarea[name="task_description"]').val();
            let taskTarget = item.find('input[name="task_target"]').val();
            let taskRating = item.find('input[name="task_rating"]').val();
            let taskWeight = item.find('input[name="task_weight"]').val();

            // Validate required fields
            if (!taskName || !startDate || !endDate) {
                toastr.error(`Please fill all required fields in task ${index + 1}`);
                submitBtn.prop('disabled', false).html('Submit');
                return false;
            }

            // Format time fields
            startTime = formatTime(startTime);
            endTime = formatTime(endTime);
            bufferTime = formatTime(bufferTime);

            // Add to form data with proper structure
            formData.append(`kt_docs_repeater_advanced[${index}][task_name]`, taskName);
            formData.append(`kt_docs_repeater_advanced[${index}][start_date]`, startDate);
            formData.append(`kt_docs_repeater_advanced[${index}][end_date]`, endDate);
            
            // Only add optional fields if they have values
            if (startTime) formData.append(`kt_docs_repeater_advanced[${index}][start_time]`, startTime);
            if (endTime) formData.append(`kt_docs_repeater_advanced[${index}][end_time]`, endTime);
            if (bufferTime) formData.append(`kt_docs_repeater_advanced[${index}][buffer_time]`, bufferTime);
            if (location) formData.append(`kt_docs_repeater_advanced[${index}][location]`, location);
            if (taskDescription) formData.append(`kt_docs_repeater_advanced[${index}][task_description]`, taskDescription);
            if (taskTarget) formData.append(`kt_docs_repeater_advanced[${index}][task_target]`, taskTarget);
            if (taskRating) formData.append(`kt_docs_repeater_advanced[${index}][task_rating]`, taskRating);
            if (taskWeight) formData.append(`kt_docs_repeater_advanced[${index}][task_weight]`, taskWeight);
        });

        // Debug: Log form data
        console.log('FormData contents:');
        for (let pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res){
                console.log('Success response:', res);
                if(res.success){
                    toastr.success(res.message);
                    // Redirect to index page with employee_id
                    setTimeout(function() {
                        window.location.href = "{{ route('admin.employee-task.index') }}?employee_id=" + employeeId;
                    }, 1000);
                } else {
                    toastr.error(res.message || 'Failed to create task');
                    submitBtn.prop('disabled', false).html('Submit');
                }
            },
            error: function(xhr){
                console.log('Error response:', xhr);
                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;
                    let message = '';
                    if (typeof errors === 'object') {
                        $.each(errors, function(key, value) {
                            message += key + ': ' + value[0] + '<br>';
                        });
                    } else {
                        message = 'Validation error occurred';
                    }
                    toastr.error(message);
                } else {
                    toastr.error('Server error occurred. Please try again.');
                    console.error('Error:', xhr.responseText);
                }
                submitBtn.prop('disabled', false).html('Submit');
            }
        });
    });

});
</script>
@endpush
@endsection
