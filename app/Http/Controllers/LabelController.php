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
            'name.unique' => 'Метка с таким именем уже существует',
        ]);

        Label::create($validated);

        flash(__('messages.The label was created successfully'))->success();

        return redirect()->route('labels.index');
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
       $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('labels', 'name')->ignore($label->id),
            ],
            'description' => 'nullable|string',
        ], [
            'name.unique' => 'Метка с таким именем уже существует',
        ]);

        $label->update($validated);
        flash(__('messages.Label changed successfully'))->success();
        return redirect()->route('labels.index');
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            return redirect()
                ->route('labels.index')
                ->with('error', __('messages.Label delete failed'));
        }

        $label->delete();
        flash(__('messages.The label was successfully deleted'))->success();
        return redirect()->route('labels.index');
    }
}