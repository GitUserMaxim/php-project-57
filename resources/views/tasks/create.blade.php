@extends('layouts.app')

@section('content')
    <section class="bg-white dark:bg-gray-900">
        <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
            <div class="grid col-span-full">
                <h1 class="mb-5 text-3xl">{{ __('messages.Create Task') }}</h1>

                <form class="w-50" method="POST" action="{{ route('tasks.store') }}">
                    @csrf

                    <div class="flex flex-col">
                        {{-- Name --}}
                        <div>
                            <label for="name">{{ __('messages.Name') }}</label>
                        </div>
                        <div class="mt-2">
                            <input class="rounded border-gray-300 w-1/3 @error('name') border-red-500 @enderror"
                                   type="text" name="name" id="name" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Description --}}
                        <div class="mt-2">
                            <label for="description">{{ __('messages.Description') }}</label>
                        </div>
                        <div class="mt-2">
                            <textarea class="rounded border-gray-300 w-1/3 h-32 @error('description') border-red-500 @enderror"
                                      name="description" id="description">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mt-2">
                            <label for="status_id">{{ __('messages.Status') }}</label>
                        </div>
                        <div class="mt-2">
                            <select name="status_id" id="status_id"
                                    class="rounded border-gray-300 w-1/3 @error('status_id') border-red-500 @enderror">
                                <option value="" disabled {{ old('status_id') ? '' : 'selected' }}></option>
                                @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" @selected(old('status_id') == $status->id)>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Assigned To --}}
                        <div class="mt-2">
                            <label for="assigned_to_id">{{ __('messages.Assigned To') }}</label>
                        </div>
                        <div class="mt-2">
                            <select name="assigned_to_id" id="assigned_to_id"
                                    class="rounded border-gray-300 w-1/3 @error('assigned_to_id') border-red-500 @enderror">
                                <option value="" disabled {{ old('assigned_to_id') ? '' : 'selected' }}></option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" @selected(old('assigned_to_id') == $user->id)>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to_id')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Labels --}}
                        <div class="mt-2">
                            <label for="labels">{{ __('messages.Labels') }}</label>
                        </div>
                        <div class="mt-2">
                            <select name="labels[]" id="labels"
                                    class="rounded border-gray-300 w-1/3 h-32 @error('labels') border-red-500 @enderror"
                                    multiple>
                                @foreach ($labels as $label)
                                    <option value="{{ $label->id }}" @selected(collect(old('labels'))->contains($label->id))>
                                        {{ $label->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('labels')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="mt-4">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" type="submit">
                                {{ __('messages.Create') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection
