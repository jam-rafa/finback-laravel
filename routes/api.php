<?php

use App\Http\Controllers\accoutController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\CostCenterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AccountController;

Route::prefix('accounts')->controller(accoutController::class)->group(function () {
    Route::get('/', 'index');       // GET /accounts
    Route::post('/', 'store');      // POST /accounts
    Route::get('/{id}', 'show');    // GET /accounts/{id}
    Route::put('/{id}', 'update');  // PUT /accounts/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /accounts/{id}
});

Route::prefix('cost-centers')->controller(CostCenterController::class)->group(function () {
    Route::get('/', 'index');       // GET /cost-centers
    Route::post('/', 'store');      // POST /cost-centers
    Route::get('/{id}', 'show');    // GET /cost-centers/{id}
    Route::put('/{id}', 'update');  // PUT /cost-centers/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /cost-centers/{id}
});

Route::prefix('event')->controller(EventController::class)->group(function () {
    Route::get('/', 'index');       // GET /cost-centers
    Route::post('/', 'store');      // POST /cost-centers
    Route::get('/{id}', 'show');    // GET /cost-centers/{id}
    Route::put('/{id}', 'update');  // PUT /cost-centers/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /cost-centers/{id}
});






Route::post('/event', [EventController::class, 'index']);
