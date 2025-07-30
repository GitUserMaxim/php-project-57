@extends('layouts.app')

@section('content')
  <div class="w-full">
    <h1 class="text-3xl mb-">{{ __('messages.Edit Task') }}</h1>

    <form method="POST" action="{{ route('tasks.update', $task) }}">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="name" class="block font-medium mb-1">{{ __('messages.Name') }}</label>
        <input type="text" name="name" id="name"
               class="w-full border rounded p-2"
               value="{{ old('name', $task->name) }}" required>
      </div>

      <div class="mb-4">
        <label for="description" class="block font-medium mb-1">{{ __('messages.Description') }}</label>
        <textarea name="description" id="description"
                  class="w-full border rounded p-2">{{ old('description', $task->description) }}</textarea>
      </div>

      <div class="mb-4">
        <label for="status_id" class="block font-medium mb-1">{{ __('messages.Status') }}</label>
        <select name="status_id" id="status_id" class="w-full border rounded p-2" required>
          @foreach ($statuses as $status)
            <option value="{{ $status->id }}"
              @selected(old('status_id', $task->task_status_id) == $status->id)>
              {{ $status->name }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-4">
    <label for="assigned_to_id" class="block font-medium mb-1">{{ __('messages.Assigned To') }}</label>
    <select name="assigned_to_id" id="assigned_to_id" class="w-full border rounded p-2">
        <option value="" {{ old('assigned_to_id', $task->assigned_to_id) ? '' : 'selected' }}></option>
        @foreach ($users as $user)
            <option value="{{ $user->id }}"
                @selected(old('assigned_to_id', $task->assigned_to_id) == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

      <div class="mb-4">
  <label for="labels" class="block font-medium mb-1">{{ __('messages.Labels') }}</label>
  <select name="labels[]" id="labels" class="w-full border rounded p-2" multiple>
    @foreach ($labels as $label)
      <option value="{{ $label->id }}"
        @selected(collect(old('labels', $task->labels->pluck('id')->toArray()))->contains($label->id))>
        {{ $label->name }}
      </option>
    @endforeach
  </select>
</div>

      <button type="submit"
              class="bg-blue-500 hover:bg-blue-700 font-bold text-white py-2 px-4 rounded">
        {{ __('messages.Update') }}
      </button>
    </form>
  </div>
@endsection
