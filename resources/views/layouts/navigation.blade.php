<header class="fixed w-full z-50">
  <nav class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 shadow-md h-16">
    <div class="max-w-screen-xl mx-auto px-4 flex items-center justify-between h-full">
      
      <!-- Левая часть: Лого -->
      <a href="{{ route('welcome') }}" class="flex items-center">
        <span class="text-xl font-semibold dark:text-white">
          {{ __('messages.Task Manager') }}
        </span>
      </a>

      <!-- Центр: Навигация -->
      <ul class="flex space-x-8 font-medium">
        <li>
          <a href="{{ route('tasks.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition">
            {{ __('messages.Tasks') }}
          </a>
        </li>
        <li>
          <a href="{{ route('task_statuses.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition">
            {{ __('messages.Statuses') }}
          </a>
        </li>
        <li>
          <a href="{{ route('labels.index') }}" class="text-gray-700 dark:text-gray-200 hover:text-blue-600 dark:hover:text-blue-400 transition">
            {{ __('messages.Labels') }}
          </a>
        </li>
      </ul>

      <!-- Правая часть: Авторизация -->
@guest
  <div class="flex items-center space-x-2">
    <button onclick="location.href='{{ route('login') }}'" 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded">
      {{ __('messages.Login') }}
    </button>
    <button onclick="location.href='{{ route('register') }}'" 
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded transition">
      {{ __('messages.Register') }}
    </button>
@else
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 border border-blue-700 rounded transition">
        {{ __('messages.Log Out') }}
      </button>
    </form>
@endguest
  </div>

    </div>
  </nav>
</header>
