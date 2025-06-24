@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4">{{ __('Create status') }}</h1>
    <form method="POST" action="{{ route('task_statuses.store') }}">
        @include('task_statuses._form', ['submitText' => __('Create')])
    </form>
</div>
@endsection
