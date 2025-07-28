@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5 text-5xl text-gray-900 dark:text-white">
                {{ __('messages.Labels') }}
            </h1>

            @auth
                <div>
                    <a href="{{ route('labels.create') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        {{ __('messages.Create Label') }}
                    </a>
                </div>
            @endauth

            <div class="overflow-x-auto mt-4">
                <table class="w-full">
                    <thead class="border-b-2 border-solid border-black text-left text-gray-900 dark:text-white">
                        <tr>
                            <th class="px-3 py-1">ID</th>
                            <th class="px-4 py-1">{{ __('messages.Name') }}</th>
                            <th class="px-4 py-1">{{ __('messages.Description') }}</th>
                            <th class="px-4 py-1">{{ __('messages.Created At') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($labels as $label)
                            <tr class="border-b border-dashed text-left text-gray-800 dark:text-white">
                                <td class="px-4 py-0">{{ $label->id }}</td>
                                <td class="px-4 py-0">{{ $label->name }}</td>
                                <td class="px-4 py-0">{{ $label->description }}</td>
                                <td class="px-4 py-0">{{ $label->created_at->format('d.m.Y') }}</td>
                                    @auth
                                        <form action="{{ route('labels.destroy', $label) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('messages.Are you sure?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 mr-4">
                                                {{ __('messages.Delete') }}
                                            </button>
                                        </form>
                                        <a href="{{ route('labels.edit', $label) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ __('messages.Edit') }}
                                        </a>
                                    @endauth
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</section>
@endsection
