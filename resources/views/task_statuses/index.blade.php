@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-2xl font-bold mb-4">{{ __('messages.Statuses') }}</h1>

    @auth
        <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            {{ __('messages.Create status') }}
        </a>
    @endauth

    <table class="min-w-full mt-4 text-white border border-gray-700">
        <thead class="bg-gray-800">
            <tr>
                <th class="px-4 py-2 border-b border-gray-600">ID</th>
                <th class="px-4 py-2 border-b border-gray-600">{{ __('messages.Status') }}</th>
                <th class="px-4 py-2 border-b border-gray-600">{{ __('messages.Date creation') }}</th>
                <th class="px-4 py-2 border-b border-gray-600">{{ __('messages.Actions') }}</th>
            </tr>
        </thead>
        <tbody class="bg-gray-900">
            @foreach ($statuses as $status)
                <tr>
                    <td class="px-4 py-2 border-b border-gray-700">{{ $status->id }}</td>
                    <td class="px-4 py-2 border-b border-gray-700">{{ $status->name }}</td>
                    <td class="px-4 py-2 border-b border-gray-700">{{ $status->created_at->format('d.m.Y') }}</td>
                    <td class="px-4 py-2 border-b border-gray-700">
                        <form action="{{ route('task_statuses.destroy', $status) }}" method="POST" class="inline-block mr-2" onsubmit="return confirm('{{ __('Are you sure you want to delete the status') }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 transition-colors duration-200">
                                {{ __('messages.Delete') }}
                            </button>
                        </form>
                        <a href="{{ route('task_statuses.edit', $status) }}" class="text-blue-500 hover:text-blue-700 transition-colors duration-200">
                            {{ __('messages.Edit') }}
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
