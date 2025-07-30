<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Label;
use Illuminate\Validation\Rule;

class LabelController extends Controller
{
    public function index()
    {
        $labels = Label::all();
        return view('labels.index', compact('labels'));
    }

    public function create()
    {
        return view('labels.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:labels,name',
            'description' => 'nullable|string',
        ], [
            'name.unique' => __('messages.The label with this name already exists'),
        ]);

        Label::create($validated);

        flash(__('messages.The label was created successfully'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable|string',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'array',
            'labels.*' => 'exists:labels,id',
    ]);

        $task->update($validated);

        $task->labels()->sync($request->input('labels', []));

        flash(__('messages.Task updated successfully'))->success();
        return redirect()->route('tasks.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            flash(__('messages.Label delete failed'))->error();
            return redirect()->route('labels.index');
        }

        $label->delete();
        flash(__('messages.The label was successfully deleted'))->success();
        return redirect()->route('labels.index');
    }
}
