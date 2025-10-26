@if($tasks->isEmpty())
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