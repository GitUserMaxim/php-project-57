<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Менеджер задач') }}</title>

    <!-- Шрифт Nunito -->
    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap"
        rel="stylesheet"
    />

    <!-- Стили и скрипты -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            
            <div class="mb-6">
                <a href="{{ url('/') }}" class="text-2xl font-bold text-black hover:text-blue-600">
                    Менеджер задач
                </a>
            </div>

            <div class="w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
