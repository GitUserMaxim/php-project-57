@extends('layouts.app')

@section('content')
<section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="grid col-span-full">
            <h1 class="mb-5 text-5xl text-gray-900 dark:text-white">
                {{ __('messages.Statuses') }}
            </h1>

            @auth
                <div class="mb-4">
                    <a href="{{ route('task_statuses.create') }}"
                       class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
                        {{ __('messages.Create status') }}
                    </a>
                </div>
            @endauth

            <div class="overflow-x-auto mt-4">
                <table class="w-full">
                    <thead class="border-b-2 border-solid border-black text-left text-gray-900 dark:text-white">
                        <tr>
                            <th class="px-4 py-2">{{ __('ID') }}</th>
                            <th class="px-4 py-2">{{ __('messages.Name') }}</th>
                            <th class="px-4 py-2">{{ __('messages.Date creation') }}</th>
                            <th class="px-4 py-2">{{ __('messages.Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($statuses as $status)
                            <tr class="border-b border-dashed text-left text-gray-800 dark:text-white">
                                <td class="px-4 py-1">{{ $status->id }}</td>
                                <td class="px-4 py-1">{{ $status->name }}</td>
                                <td class="px-4 py-1">{{ $status->created_at->format('d.m.Y') }}</td>
                                <td class="px-4 py-1">
                                    @auth
                                        <form action="{{ route('task_statuses.destroy', $status) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure you want to delete the status?') }}');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 mr-4">
                                                {{ __('messages.Delete') }}
                                            </button>
                                        </form>
                                        <a href="{{ route('task_statuses.edit', $status) }}" class="text-blue-600 hover:text-blue-900">
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
