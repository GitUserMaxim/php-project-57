<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laracasts\Flash\Flash;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TaskStatus::class, 'task_status');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $statuses = TaskStatus::all();
        return view('task_statuses.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('task_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        TaskStatus::create($request->only('name'));

         flash(__('messages.Status successfully created'))->success();

        return redirect()->route('task_statuses.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskStatus $task_status)
    {
        return view('task_statuses.edit', compact('task_status'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TaskStatus $task_status)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $task_status->update($request->only('name'));

          flash(__('Статус успешно изменён'))->success();
          return redirect()->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $task_status)
    {
        if ($task_status->tasks()->exists()) {
            flash(__('Невозможно удалить статус с назначенными задачами'))->error();
            return redirect()->route('task_statuses.index');
        }

        $task_status->delete();
        flash(__('Статус успешно удалён'))->success();
        return redirect()->route('task_statuses.index');
    }
}
