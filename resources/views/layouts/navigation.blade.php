<header class="fixed w-full z-50">
  <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-md h-16">
    <div class="max-w-screen-xl mx-auto px-4 grid grid-cols-3 items-center">
      <!-- Левая часть: Лого -->
      <div>
        <a href="{{ route('welcome') }}" class="flex items-center ml-2">
          <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">
            {{ __('messages.Task Manager') }}
          </span>
        </a>
      </div>

      <!-- Центр: Навигация -->
      <div class="justify-center flex">
        <ul class="flex space-x-8 font-medium items-center">
          <li><a href="{{ route('tasks.index') }}" class="text-gray-700 hover:text-blue-700">{{ __('messages.Tasks') }}</a></li>
          <li><a href="{{ route('task_statuses.index') }}" class="text-gray-700 hover:text-blue-700">{{ __('messages.Statuses') }}</a></li>
          <li><a href="{{ route('labels.index') }}" class="text-gray-700 hover:text-blue-700">{{ __('messages.Labels') }}</a></li>
        </ul>
      </div>

      <!-- Правая часть: Авторизация -->
      <div class="justify-end flex space-x-2 items-center">
        @guest
          <a href="{{ route('login') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('messages.Login') }}
          </a>
          <a href="{{ route('register') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            {{ __('messages.Register') }}
          </a>
        @else
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
              {{ __('messages.Log Out') }}
            </button>
          </form>
        @endguest
      </div>
    </div>
  </nav>
</header>
