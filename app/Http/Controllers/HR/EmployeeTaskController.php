<?php

namespace App\Http\Controllers\HR;

use App\Models\Admin;
use App\Models\HR\Task;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\HR\EmployeeTask;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class EmployeeTaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
public function index(Request $request)
{
    $employees = \App\Models\Admin::all();
    $selectedEmployeeId = $request->query('employee_id');

    $tasks = collect();
    
    if ($selectedEmployeeId) {
        $tasks = Task::where('employee_id', $selectedEmployeeId)->get();
    }

    // Check if it's an AJAX request
    if ($request->ajax() || $request->has('ajax')) {
        $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();
        return response()->json(['html' => $html]);
    }

    return view('admin.pages.employeeTask.index', compact('employees', 'tasks', 'selectedEmployeeId'));
}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'employees' => Admin::get(),
        ];
        return view('admin.pages.employeeTask.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {
    //     $validator = $request->validate([
    //         'employee_id'    => 'required|exists:admins,id',
    //         'title'          => 'nullable|string',
    //         'year'           => 'nullable|integer',
    //         'quarter'        => 'nullable|in:q1,q2,q3,q4',
    //         'month'          => 'nullable|string',
    //         'supervisors'    => 'nullable|array',
    //         'supervisors.*'  => 'exists:admins,id',
    //         'notify_id'      => 'nullable|array',
    //         'notify_id.*'    => 'exists:admins,id',
    //         'kt_docs_repeater_advanced' => 'nullable|array',
    //         'kt_docs_repeater_advanced.*.task_name'        => 'required|string',
    //         'kt_docs_repeater_advanced.*.start_date'       => 'required|date',
    //         'kt_docs_repeater_advanced.*.end_date'         => 'required|date|after_or_equal:kt_docs_repeater_advanced.*.start_date',
    //         'kt_docs_repeater_advanced.*.start_time'       => 'nullable|date_format:H:i',
    //         'kt_docs_repeater_advanced.*.end_time'         => 'nullable|date_format:H:i|after:kt_docs_repeater_advanced.*.start_time',
    //         'kt_docs_repeater_advanced.*.buffer_time'      => 'nullable|date_format:H:i',
    //         'kt_docs_repeater_advanced.*.location'         => 'nullable|string',
    //         'kt_docs_repeater_advanced.*.task_description' => 'nullable|string',
    //         'kt_docs_repeater_advanced.*.task_target'      => 'nullable|string',
    //         'kt_docs_repeater_advanced.*.task_rating'      => 'nullable|string',
    //         'kt_docs_repeater_advanced.*.task_weight'      => 'nullable|integer',
    //     ]);

    //     if ($validator) {
    //         $tasks = $request->kt_docs_repeater_advanced;

    //         $employeeTaskData = [
    //             'employee_id' => $request->employee_id,
    //             'title'       => $request->title,
    //             'fiscal_year' => $request->year,
    //             'quarter'     => $request->quarter,
    //             'month'       => $request->month,
    //             'supervisors' => $request->supervisors,
    //             'notify_id'   => $request->notify_id,
    //             'status'      => 'pending',
    //         ];

    //         $employeeTask = EmployeeTask::create($employeeTaskData);

    //         if ($tasks) {
    //             foreach ($tasks as $task) {
    //                 Task::create([
    //                     'employee_id'      => $employeeTask->employee_id,
    //                     'employee_task_id' => $employeeTask->id,
    //                     'task_name'        => $task['task_name'],
    //                     'start_date'       => $task['start_date'],
    //                     'end_date'         => $task['end_date'],
    //                     'start_time'       => $task['start_time'],
    //                     'end_time'         => $task['end_time'],
    //                     'buffer_time'      => $task['buffer_time'],
    //                     'location'         => $task['location'],
    //                     'task_description' => $task['task_description'],
    //                     'task_target'      => $task['task_target'],
    //                     'task_rating'      => $task['task_rating'],
    //                     'task_weight'      => $task['task_weight'],
    //                 ]);
    //             }
    //         }
    //         Session::flash('success', 'Data saved successfully.');
    //         return redirect()->back();    ///->with('success', 'Data saved successfully.')
    //     }

    //     return redirect()->back()->withErrors($validator)->withInput();
    // }
 public function store(Request $request)
{
    // 1️⃣ Validate
    $validated = $request->validate([
        'employee_id'    => 'required|exists:admins,id',
        'title'          => 'nullable|string',
        'year'           => 'nullable|integer',
        'quarter'        => 'nullable|in:q1,q2,q3,q4',
        'month'          => 'nullable|string',
        'supervisors'    => 'nullable|array',
        'supervisors.*'  => 'exists:admins,id',
        'notify_id'      => 'nullable|array',
        'notify_id.*'    => 'exists:admins,id',
        'kt_docs_repeater_advanced' => 'nullable|array',
        'kt_docs_repeater_advanced.*.task_name'        => 'required|string',
        'kt_docs_repeater_advanced.*.start_date'       => 'required|date',
        'kt_docs_repeater_advanced.*.end_date'         => 'required|date',
        'kt_docs_repeater_advanced.*.start_time'       => 'nullable|date_format:H:i',
        'kt_docs_repeater_advanced.*.end_time'         => 'nullable|date_format:H:i',
        'kt_docs_repeater_advanced.*.buffer_time'      => 'nullable|date_format:H:i',
        'kt_docs_repeater_advanced.*.location'         => 'nullable|string',
        'kt_docs_repeater_advanced.*.task_description' => 'nullable|string',
        'kt_docs_repeater_advanced.*.task_target'      => 'nullable|string',
        'kt_docs_repeater_advanced.*.task_rating'      => 'nullable|string',
        'kt_docs_repeater_advanced.*.task_weight'      => 'nullable|integer',
    ]);

    $tasks = $validated['kt_docs_repeater_advanced'] ?? [];

    // 2️⃣ Prepare EmployeeTask data
    $employeeTaskData = [
        'employee_id' => $validated['employee_id'],
        'title'       => $validated['title'] ?? null,
        'fiscal_year' => $validated['year'] ?? null,
        'quarter'     => $validated['quarter'] ?? null,
        'month'       => $validated['month'] ?? null,
        'supervisors' => $validated['supervisors'] ?? null,
        'notify_id'   => $validated['notify_id'] ?? null,
        'status'      => 'not_done',
        'slug'        => Str::slug($validated['title'] ?? 'task-' . now()->timestamp),
    ];

    // 3️⃣ Save EmployeeTask
    $employeeTask = EmployeeTask::create($employeeTaskData);

    // 4️⃣ Save each Task
    foreach ($tasks as $task) {
        Task::create([
            'employee_id'      => $employeeTask->employee_id,
            'employee_task_id' => $employeeTask->id,
            'task_name'        => $task['task_name'],
            'start_date'       => $task['start_date'],
            'end_date'         => $task['end_date'],
            'start_time'       => $task['start_time'] ?? null,
            'end_time'         => $task['end_time'] ?? null,
            'buffer_time'      => $task['buffer_time'] ?? null,
            'location'         => $task['location'] ?? null,
            'task_description' => $task['task_description'] ?? null,
            'slug'             => Str::slug($task['task_name'] . '-' . now()->timestamp),
        ]);
    }

    // 5️⃣ Return updated tasks table HTML for AJAX
    $tasks = Task::where('employee_id', $validated['employee_id'])->get();
    $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();

    return response()->json([
        'success' => true,
        'message' => 'Task added successfully!',
        'html'    => $html,
        'employee_id' => $validated['employee_id'] // Return the employee ID
    ]);
}




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function edit($id)
    {
        $task = Task::findOrFail($id);
        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        $validated = $request->validate([
            'task_name'  => 'required|string',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $task->update([
            'task_name'  => $validated['task_name'],
            'start_date' => $validated['start_date'],
            'end_date'   => $validated['end_date'],
        ]);

        $tasks = Task::where('employee_id', $task->employee_id)->get();
        $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();

        return response()->json([
            'success' => true,
            'message' => 'Task updated successfully!',
            'html'    => $html
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'html'    => $html
        ]);
    }

    public function monthlyTasks($employeeId)
{
    $tasks = Task::where('employee_id', $employeeId)->get();
    $html = view('admin.pages.employeeTask.partials.monthly_task_table', compact('tasks'))->render();
    return response()->json(['html' => $html]);
}

}
