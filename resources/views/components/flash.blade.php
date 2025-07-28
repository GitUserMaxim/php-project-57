@if (session()->has('flash_notification'))
    @foreach (session('flash_notification', collect())->toArray() as $message)
        @if (!empty($message['message']))
            @php
                $level = $message['level'];
                $colors = [
                    'success' => 'bg-green-100 border-green-400 text-green-800',
                    'error'   => 'bg-red-100 border-red-400 text-red-800',
                    'warning' => 'bg-yellow-100 border-yellow-400 text-yellow-800',
                    'info'    => 'bg-blue-100 border-blue-400 text-blue-800',
                ];
            @endphp
            <div class="border-l-4 p-4 my-2 rounded {{ $colors[$level] ?? 'bg-gray-100 border-gray-400 text-gray-800' }}">
                {!! $message['message'] !!}
            </div>
        @endif
    @endforeach
@endif