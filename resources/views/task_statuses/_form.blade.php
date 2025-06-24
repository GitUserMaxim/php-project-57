@csrf
<div class="mb-4">
    <label for="name">{{ __('Name') }}</label>
    <input type="text" name="name" value="{{ old('name', $task_status->name ?? '') }}" required class="border p-2 w-full" />
</div>
<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
    {{ $submitText ?? __('Save') }}
</button>
