@extends('layouts.app')

@section('content')
  <section class="bg-white dark:bg-gray-900">
    <div class="grid max-w-screen-xl px-4 pt-20 pb-8 mx-auto lg:gap-8 xl:gap-0 lg:py-16 lg:grid-cols-12 lg:pt-28">
        <div class="col-span-full">
            <h1 class="mb-5 text-5xl text-gray-900 dark:text-white">
                {{ __('messages.Tasks') }}
            </h1>
      @auth
      <a href="{{ route('tasks.create') }}"
         class="inline-block mb-6 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
        {{ __('messages.Create Task') }}
      </a>
      @endauth
      <form method="GET" action="{{ route('tasks.index') }}" class="flex gap-4 mb-4">
    <select name="filter[status_id]">
        <option value="">Статус</option>
        @foreach($statuses as $status)
            <option value="{{ $status->id }}" @selected(request('filter.status_id') == $status->id)>
                {{ $status->name }}
            </option>
        @endforeach
    </select>

    <select name="filter[created_by_id]">
        <option value="">Автор</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" @selected(request('filter.created_by_id') == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>

    <select name="filter[assigned_to_id]">
        <option value="">Исполнитель</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" @selected(request('filter.assigned_to_id') == $user->id)>
                {{ $user->name }}
            </option>
        @endforeach
    </select>

   <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded transition">
    {{ __('messages.Apply') }}
</button>

</form>
      <div class="overflow-x-auto mt-4">
                <table class="w-full">
                    <thead class="border-b-2 border-solid border-black text-left text-gray-900 dark:text-white">
            <tr>
              <th class="px-4 py-0 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                {{ __('ID') }}
              </th>
              <th class="px-4 py-0 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                {{ __('messages.Status') }}
              </th>
              <th class="px-4 py-0 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                {{ __('messages.Name') }}
              </th>
              <th class="px-4 py-0 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                {{ __('messages.Created By') }}
              </th>
              <th class="px-4 py-0 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                {{ __('messages.Assigned To') }}
              </th>
              <th class="px-4 py-0 text-left text-xs font-bold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                {{ __('messages.Created At') }}
              </th>
            </tr>
          </thead>
          <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @foreach ($tasks as $task)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                  {{ $task->id }}
                </td>
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                  {{ $task->status->name ?? '-' }}
                </td>
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                  <a href="{{ route('tasks.show', $task) }}"
                     class="text-blue-600 dark:text-blue-400 hover:underline">
                    {{ $task->name }}
                  </a>
                </td>
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                  {{ $task->creator->name ?? '-' }}
                </td>
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                  {{ $task->assignee->name ?? '-' }}
                </td>
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap">
                  {{ $task->created_at->format('Y-m-d H:i') }}
                </td>
                <td class="px-4 py-3 text-gray-800 dark:text-gray-200 whitespace-nowrap space-x-2">
                  @auth
                    <a href="{{ route('tasks.edit', $task) }}"
                       class="text-blue-600 dark:text-blue-400 hover:underline">
                      {{ __('messages.Edit') }}
                    </a>

                    @if (Auth::id() === $task->created_by_id)
                      <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('{{ __('messages.Are you sure?') }}')"
                                class="text-red-600 dark:text-red-400 hover:underline">
                          {{ __('messages.Delete') }}
                        </button>
                      </form>
                    @endif
                  @endauth
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
