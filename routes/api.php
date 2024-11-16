<?php

use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/rafa', function () {
    return response()->json(['message' => 'Bem-vindo à API!']);
});


Route::post('/event', [EventController::class, 'index']);
