@csrf
<div class="mb-4">
    <label for="name">{{ __('messages.Name') }}</label>
    <input type="text" name="name" value="{{ old('name', $task_status->name ?? '') }}" required class="border p-2 w-full" />
</div>
@error('name')
    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
@enderror
<button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">
    {{ $submitText ?? __('Save') }}
</button>
