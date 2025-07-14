@extends('layouts.app')

@section('content')
  <div class="w-full">
    <h1 class="text-2xl font-bold mb-4">{{ $task->name }}</h1>

    <div class="mb-2">
      <strong>{{ __('messages.Description') }}:</strong>
      <p>{{ $task->description }}</p>
    </div>

    <div class="mb-2">
      <strong>{{ __('messages.Status') }}:</strong>
      <p>{{ $task->status->name ?? '-' }}</p>
    </div>

    <div class="mb-2">
      <strong>{{ __('messages.Created By') }}:</strong>
      <p>{{ $task->creator->name ?? '-' }}</p>
    </div>

    <div class="mb-4">
      <strong>{{ __('messages.Assigned To') }}:</strong>
      <p>{{ $task->assignee->name ?? '-' }}</p>
    </div>
    @auth
    <a href="{{ route('tasks.index') }}"
       class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
      {{ __('messages.Back to list') }}
    </a>
    @endauth
  </div>
@endsection
