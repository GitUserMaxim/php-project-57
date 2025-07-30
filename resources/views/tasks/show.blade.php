@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 mt-8">
        <h1 class="text-3xl mb-4">
            {{ __('messages.View task') }}: {{ $task->name }}
        </h1>

        <div class="mb-4">
            <p><strong>{{ __('messages.Name') }}:</strong> {{ $task->name }}</p>
        </div>

        <div class="mb-4">
            <p><strong>{{ __('messages.Status') }}:</strong> {{ $task->status->name }}</p>
        </div>

        <div class="mb-4">
            <p><strong>{{ __('messages.Description') }}:</strong> {{ $task->description }}</p>
        </div>

        <div class="mb-4">
            <p><strong>{{ __('messages.Labels') }}:</strong>
                {{ $task->labels->pluck('name')->implode(', ') ?: '—' }}
            </p>
        </div>
    </div>
@endsection
