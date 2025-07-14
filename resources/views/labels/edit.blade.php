@extends('layouts.app')

@section('content')
  <div class="w-full flex justify-center">
    <div class="w-full max-w-md mx-auto">
      <h1 class="text-3xl font-bold mb-6 text-gray-800 dark:text-gray-100">{{ __('messages.Edit Label') }}</h1>

      <form method="POST" action="{{ route('labels.update', $label) }}">
        @csrf
        @method('PATCH')

        <div class="mb-4">
          <label for="name" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">{{ __('messages.Name') }}</label>
          <input type="text" id="name" name="name" class="w-full p-2 border rounded"
                 value="{{ old('name', $label->name) }}" required>
        </div>

        <div class="mb-4">
          <label for="description" class="block text-gray-700 dark:text-gray-200 font-bold mb-2">{{ __('messages.Description') }}</label>
          <textarea id="description" name="description" class="w-full p-2 border rounded">{{ old('description', $label->description) }}</textarea>
        </div>

        <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
          {{ __('messages.Update') }}
        </button>
      </form>
    </div>
  </div>
@endsection
