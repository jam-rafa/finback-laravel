<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\CostCenterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\AccountCostCenterController;
use App\Http\Controllers\Api\DashBoard\RevenueController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\NatureController;
use App\Http\Controllers\NatureTypeController;
use App\Http\Controllers\PaymentTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserController;

Route::prefix('accounts')->controller(AccountController::class)->group(function () {
    Route::get('/', 'index');       // GET /accounts
    Route::post('/', 'store');      // POST /accounts
    Route::get('/{id}', 'show');    // GET /accounts/{id}
    Route::put('/{id}', 'update');  // PUT /accounts/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /accounts/{id}
});


Route::prefix('roles')->controller(RoleController::class)->group(function () {
    Route::get('/', 'index');       // GET /roles
    Route::post('/', 'store');      // POST /roles
    Route::get('/{id}', 'show');    // GET /roles/{id}
    Route::put('/{id}', 'update');  // PUT /roles/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /roles/{id}
});


Route::prefix('users')->controller(UserController::class)->group(function () {
    Route::get('/', 'index');       // GET /users
    Route::post('/', 'store');      // POST /users
    Route::get('/{id}', 'show');    // GET /users/{id}
    Route::put('/{id}', 'update');  // PUT /users/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /users/{id}
});


Route::prefix('cost-centers')->controller(CostCenterController::class)->group(function () {
    Route::get('/', 'index');       // GET /cost-centers
    Route::post('/', 'store');      // POST /cost-centers
    Route::get('/{id}', 'show');    // GET /cost-centers/{id}
    Route::put('/{id}', 'update');  // PUT /cost-centers/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /cost-centers/{id}
});

Route::prefix('natures')->controller(NatureController::class)->group(function () {
    Route::get('/', 'index');       // GET /natures
    Route::post('/', 'store');      // POST /natures
    Route::get('/{id}', 'show');    // GET /natures/{id}
    Route::put('/{id}', 'update');  // PUT /natures/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /natures/{id}
});


Route::prefix('payment-types')->controller(PaymentTypeController::class)->group(function () {
    Route::get('/', 'index');       // GET /payment-types
    Route::post('/', 'store');      // POST /payment-types
    Route::get('/{id}', 'show');    // GET /payment-types/{id}
    Route::put('/{id}', 'update');  // PUT /payment-types/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /payment-types/{id}
});

Route::prefix('users-accounts')->controller(UserAccountController::class)->group(function () {
    Route::get('/', 'index');       // GET /users-accounts
    Route::post('/', 'store');      // POST /users-accounts
    Route::get('/{id}', 'show');    // GET /users-accounts/{id}
    Route::put('/{id}', 'update');  // PUT /users-accounts/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /users-accounts/{id}
});


Route::prefix('account-cost-centers')->controller(AccountCostCenterController::class)->group(function () {
    Route::get('/', 'index');       // GET /account-cost-centers
    Route::post('/', 'store');      // POST /account-cost-centers
    Route::get('/{id}', 'show');    // GET /account-cost-centers/{id}
    Route::put('/{id}', 'update');  // PUT /account-cost-centers/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /account-cost-centers/{id}
});


Route::prefix('nature-types')->controller(NatureTypeController::class)->group(function () {
    Route::get('/', 'index');       // GET /nature-types
    Route::post('/', 'store');      // POST /nature-types
    Route::get('/{id}', 'show');    // GET /nature-types/{id}
    Route::put('/{id}', 'update');  // PUT /nature-types/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /nature-types/{id}
});


Route::prefix('movements')->controller(MovementController::class)->group(function () {
    Route::get('/', 'index');       // GET /movements
    Route::post('/', 'store');      // POST /movements
    Route::get('/{id}', 'show');    // GET /movements/{id}
    Route::put('/{id}', 'update');  // PUT /movements/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /movements/{id}
});


Route::prefix('event')->controller(EventController::class)->group(function () {
    Route::get('/', 'index');       // GET /cost-centers
    Route::post('/', 'store');      // POST /cost-centers
    Route::get('/{id}', 'show');    // GET /cost-centers/{id}
    Route::put('/{id}', 'update');  // PUT /cost-centers/{id}
    Route::delete('/{id}', 'destroy'); // DELETE /cost-centers/{id}
});


Route::get('/dashboard/revenue', [RevenueController::class, 'index']);
