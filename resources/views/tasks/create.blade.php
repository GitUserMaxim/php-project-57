@extends('layouts.app')

@section('content')
  <div class="w-full">
    <h1 class="text-2xl mb-4">{{ __('messages.Create Task') }}</h1>

    <form method="POST" action="{{ route('tasks.store') }}">
      @csrf

      <div class="mb-4">
        <label for="name" class="block font-medium mb-1">{{ __('messages.Name') }}</label>
        <input type="text" name="name" id="name"
               class="w-full border rounded p-2"
               value="{{ old('name') }}" required>
      </div>

      <div class="mb-4">
        <label for="description" class="block font-medium mb-1">{{ __('messages.Description') }}</label>
        <textarea name="description" id="description"
                  class="w-full border rounded p-2">{{ old('description') }}</textarea>
      </div>

      <div class="mb-4">
    <label for="status_id" class="block font-medium mb-1">{{ __('messages.Status') }}</label>
       <select name="status_id" id="status_id" class="w-full border rounded p-2" required>
         <option value="" disabled {{ old('status_id') ? '' : 'selected' }}>
        </option>
           @foreach ($statuses as $status)
      <option value="{{ $status->id }}" @selected(old('status_id') == $status->id)>
        {{ $status->name }}
      </option>
       @endforeach
       </select>
      </div>

      <div class="mb-4">
  <label for="assigned_to_id" class="block font-medium mb-1">{{ __('messages.Assigned To') }}</label>
  <select name="assigned_to_id" id="assigned_to_id" class="w-full border rounded p-2">
    <option value="" disabled {{ old('assigned_to_id') ? '' : 'selected' }}>
    </option>
    @foreach ($users as $user)
      <option value="{{ $user->id }}" @selected(old('assigned_to_id') == $user->id)>
        {{ $user->name }}
      </option>
    @endforeach
  </select>
</div>

      <div class="mb-4">
        <label for="labels" class="block font-medium mb-1">{{ __('messages.Labels') }}</label>
        <select name="labels[]" id="labels" class="w-full border rounded p-2" multiple>
          @foreach ($labels as $label)
            <option value="{{ $label->id }}" @selected(collect(old('labels'))->contains($label->id))>
              {{ $label->name }}
            </option>
          @endforeach
        </select>
      </div>
      <button type="submit"
              class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        {{ __('messages.Save') }}
      </button>
    </form>
  </div>
@endsection
