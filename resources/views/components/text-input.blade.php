@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge([
    'class' => 'border-gray-300 bg-white text-black focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 rounded-md shadow-sm'
]) }}>
