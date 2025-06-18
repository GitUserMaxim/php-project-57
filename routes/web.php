<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test-sentry', function () {
    throw new \Exception('Проверка Sentry в бою!');
});