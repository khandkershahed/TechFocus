<?php

namespace App\Http\Controllers\HR;

use App\Models\Admin;
use App\Models\HR\Task;
use App\Models\HR\EmployeeTask;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EmployeeTaskController extends Controller
{
    // Display employee list and tasks table
    public function index()
    {
        $data = [
            'employees' => Admin::all(),
        ];
        return view('admin.pages.employeeTask.index', $data);
    }

    // Fetch tasks for selected employee via AJAX
    public function employeeTasks($employeeId)
    {
        $tasks = Task::where('employee_id', $employeeId)->get();
        $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    // Store a new task via AJAX
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:admins,id',
            'task_name'   => 'required|string',
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
        ]);

        Task::create([
            'employee_id' => $validated['employee_id'],
            'task_name'   => $validated['task_name'],
            'start_date'  => $validated['start_date'],
            'end_date'    => $validated['end_date'],
            'slug'        => Str::slug($validated['task_name'] . '-' . now()->timestamp),
        ]);

        $tasks = Task::where('employee_id', $validated['employee_id'])->get();
        $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Task added successfully!',
            'html'    => $html,
        ]);
    }

    // Fetch single task for edit
    public function edit($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    // Update task via AJAX
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'task_name'  => 'required|string',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $task->update($validated);

        $tasks = Task::where('employee_id', $task->employee_id)->get();
        $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
            'html'    => $html,
        ]);
    }

    // Delete task via AJAX
    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $employeeId = $task->employee_id;
        $task->delete();

        $tasks = Task::where('employee_id', $employeeId)->get();
        $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Task deleted successfully!',
            'html'    => $html,
        ]);
    }
}
