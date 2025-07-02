<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\TaskStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskStatusController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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

        return redirect()->route('task_statuses.index')
            ->with('success', __('Status created successfully.'));
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

        return redirect()->route('task_statuses.index')
            ->with('success', __('Status updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TaskStatus $task_status)
    {
        if ($task_status->tasks()->exists()) {
            return redirect()->route('task_statuses.index')
                ->with('error', __('Cannot delete status with tasks.'));
        }

        $task_status->delete();
        return redirect()->route('task_statuses.index')
            ->with('success', __('Status deleted successfully.'));
    
    }
}
