<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index()
    {
        $tasks = Task::with(['status', 'creator', 'assignee', 'labels'])->get();
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        $task->load(['labels', 'creator', 'assignee', 'status']);
        return view('tasks.show', compact('task'));
    }

    public function create()
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('tasks.create', compact('statuses', 'users', 'labels'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'array',
            'labels.*' => 'exists:labels,id',
    ]);

        $validated['created_by_id'] = auth()->id();

        $task = Task::create($validated);

        if ($request->has('labels')) {
            $task->labels()->sync($request->input('labels'));
    }
        flash(__('messages.The task was successfully created'))->success();
        return redirect()->route('tasks.index')->with('success', 'Task created.');
    }

    public function edit(Task $task)
    {
        $statuses = TaskStatus::all();
        $users = User::all();
        $labels = Label::all();
        return view('tasks.edit', compact('task', 'statuses', 'users', 'labels'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);

        flash(__('messages.The task has been successfully updated'))->success();
        return redirect()->route('tasks.index')->with('success', 'Task updated.');
    }

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task); // ← ВАЖНО

        $task->delete();
        
        flash(__('messages.The task was successfully deleted'))->success();
        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
