<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function index(Request $request)
    {
        $tasks = QueryBuilder::for(Task::class)
            ->allowedFilters([
                AllowedFilter::exact('status_id'),
                AllowedFilter::exact('created_by_id'),
                AllowedFilter::exact('assigned_to_id'),
            ])
            ->with(['status', 'creator', 'assignee'])
            ->paginate(15)
            ->appends($request->query());

        $statuses = TaskStatus::all();
        $users = User::all();

        return view('tasks.index', compact('tasks', 'statuses', 'users'));
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
            'name' => 'required|string|unique:tasks,name',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'array',
            'labels.*' => 'exists:labels,id',
        ], [
            'name.unique' => 'Задача с таким именем уже существует',
        ]);

        $validated['created_by_id'] = auth()->id();

        $task = Task::create($validated);
        $task->labels()->sync($request->input('labels', []));

        flash(__('messages.The task was successfully created'))->success();
            return redirect()->route('tasks.index');
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
            'name' => [
                'required',
                'string',
                Rule::unique('tasks', 'name')->ignore($task->id),
            ],
        'description' => 'nullable|string',
        'status_id' => 'required|exists:task_statuses,id',
        'assigned_to_id' => 'nullable|exists:users,id',
        'labels' => 'array',
        'labels.*' => 'exists:labels,id',
    ], [
        'name.unique' => 'Задача с таким именем уже существует',
    ]);

        $task->update($validated);
        $task->labels()->sync($request->input('labels', []));

        flash(__('messages.The task has been successfully updated'))->success();
        return redirect()->route('tasks.index');
    }


    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();
        
        flash(__('messages.The task was successfully deleted'))->success();
        return redirect()->route('tasks.index')->with('success', 'Task deleted.');
    }
}
