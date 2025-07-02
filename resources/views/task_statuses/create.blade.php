@extends('layouts.app')

@section('content')
<div class="container mx-auto py-12">
    <h1 class="text-2xl font-bold mb-4">{{ __('messages.Create status') }}</h1>
    <form method="POST" action="{{ route('task_statuses.store') }}">
        @include('task_statuses._form', ['submitText' => __('messages.Create')])
    </form>
</div>
@endsection