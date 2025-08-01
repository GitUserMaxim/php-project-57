@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5 text-3xl font-bold text-gray-800 dark:text-white">
                {{ __('messages.Edit Task') }}
            </h1>

            <form class="w-50" method="POST" action="{{ route('tasks.update', $task) }}">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div class="flex flex-col mb-4">
                    <label for="name" class="text-gray-700 dark:text-gray-300">{{ __('messages.Name') }}</label>
                    <div class="mt-2">
                        <input class="rounded border-gray-300 w-1/3 @error('name') border-red-500 @enderror"
                               type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $task->name) }}"
                               required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Description --}}
                <div class="flex flex-col mb-4">
                    <label for="description" class="text-gray-700 dark:text-gray-300">{{ __('messages.Description') }}</label>
                    <div class="mt-2">
                        <textarea class="rounded border-gray-300 w-1/3"
                                  name="description"
                                  id="description"
                                  rows="4">{{ old('description', $task->description) }}</textarea>
                    </div>
                </div>

                {{-- Status --}}
                <div class="flex flex-col mb-4">
                    <label for="status_id" class="text-gray-700 dark:text-gray-300">{{ __('messages.Status') }}</label>
                    <div class="mt-2">
                        <select class="rounded border-gray-300 w-1/3"
                                name="status_id"
                                id="status_id"
                                required>
                            @foreach ($statuses as $status)
                                <option value="{{ $status->id }}"
                                    @selected(old('status_id', $task->task_status_id) == $status->id)>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Assigned To --}}
                <div class="flex flex-col mb-4">
                    <label for="assigned_to_id" class="text-gray-700 dark:text-gray-300">{{ __('messages.Assigned To') }}</label>
                    <div class="mt-2">
                        <select class="rounded border-gray-300 w-1/3"
                                name="assigned_to_id"
                                id="assigned_to_id">
                            <option value="" {{ old('assigned_to_id', $task->assigned_to_id) ? '' : 'selected' }}></option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    @selected(old('assigned_to_id', $task->assigned_to_id) == $user->id)>
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Labels --}}
                <div class="flex flex-col mb-4">
                    <label for="labels" class="text-gray-700 dark:text-gray-300">{{ __('messages.Labels') }}</label>
                    <div class="mt-2">
                        <select class="rounded border-gray-300 w-1/3"
                                name="labels[]"
                                id="labels"
                                multiple>
                            @foreach ($labels as $label)
                                <option value="{{ $label->id }}"
                                    @selected(collect(old('labels', $task->labels->pluck('id')->toArray()))->contains($label->id))>
                                    {{ $label->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mt-4">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">
                        {{ __('messages.Update') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
