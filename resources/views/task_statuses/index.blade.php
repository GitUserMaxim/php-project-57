@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">{{ __('Task statuses') }}</h1>

    @auth
        <a href="{{ route('task_statuses.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">
            {{ __('Create status') }}
        </a>
    @endauth

    <table class="min-w-full mt-4">
        <thead><tr><th>{{ __('Name') }}</th><th></th></tr></thead>
        <tbody>
        @foreach ($statuses as $status)
            <tr>
                <td>{{ $status->name }}</td>
                <td class="text-right">
                    @auth
                        <a href="{{ route('task_statuses.edit', $status) }}" class="text-blue-600">{{ __('Edit') }}</a>

                        <form action="{{ route('task_statuses.destroy', $status) }}" method="POST" class="inline-block" onsubmit="return confirm('{{ __('Are you sure?') }}');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 ml-2">{{ __('Delete') }}</button>
                        </form>
                    @endauth
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection
