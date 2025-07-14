<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Label;

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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Label::create($validated);

        return redirect()->route('labels.index')->with('success', __('messages.Label created successfully'));
    }

    public function edit(Label $label)
    {
        return view('labels.edit', compact('label'));
    }

    public function update(Request $request, Label $label)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $label->update($validated);

        return redirect()->route('labels.index')->with('success', __('messages.Label updated successfully'));
    }

    public function destroy(Label $label)
    {
        if ($label->tasks()->exists()) {
            return redirect()
                ->route('labels.index')
                ->with('error', __('messages.Label delete failed'));
        }

        $label->delete();

        return redirect()->route('labels.index')->with('success', __('messages.Label deleted'));
    }
}