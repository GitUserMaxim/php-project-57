@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5 text-3xl font-bold text-gray-800 dark:text-white">
                {{ __('messages.Edit Label') }}
            </h1>

            <form class="w-50" method="POST" action="{{ route('labels.update', $label) }}">
                @csrf
                @method('PATCH')

                <div class="flex flex-col">
                    {{-- Name Field --}}
                    <div>
                        <label for="name" class="text-gray-700 dark:text-gray-300">{{ __('messages.Name') }}</label>
                    </div>
                    <div class="mt-2">
                        <input
                            class="rounded border-gray-300 w-1/3 @error('name') border-red-500 @enderror"
                            type="text"
                            name="name"
                            id="name"
                            value="{{ old('name', $label->name) }}"
                            required
                        >
                        @error('name')
                            <p class="text-red-600 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description Field --}}
                    <div class="mt-4">
                        <label for="description" class="text-gray-700 dark:text-gray-300">{{ __('messages.Description') }}</label>
                    </div>
                    <div class="mt-2">
                        <textarea
                            class="rounded border-gray-300 w-1/3"
                            id="description"
                            name="description"
                            rows="4"
                        >{{ old('description', $label->description) }}</textarea>
                    </div>

                    {{-- Submit Button --}}
                    <div class="mt-4">
                        <button
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            type="submit">
                            {{ __('messages.Update label') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
