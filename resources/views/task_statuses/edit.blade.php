@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">{{ __('Edit status') }}</h1>
    <form method="POST" action="{{ route('task_statuses.update', $task_status) }}">
        @method('PATCH')
        @include('task_statuses._form', ['submitText' => __('Update')])
    </form>
</div>
@endsection
