<?php

use App\Http\Controllers\accoutController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('login')->controller(LoginController::class)->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
});
