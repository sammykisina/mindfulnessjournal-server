<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return [];
})->name(name: 'home');

/**
 * AUTH
 */
Route::prefix('auth')->as('auth:')->group(function () {
    Route::post('register', Auth\RegisterController::class)->name(name: 'register');
    Route::post('login', Auth\LoginController::class)->name(name: 'login');

    Route::group([
        'middleware' => ['auth:sanctum'],
    ], function () {
        Route::get('profile', Auth\ProfileController::class)->name(name: 'profile');
        Route::post('logout', Auth\LogoutController::class)->name(name: 'logout');
    });
});

/**
 * ADMIN USER ROUTES
 */
Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::prefix('admin')->as('admin:')->group(function () {
        Route::prefix('users')->as('users:')->group(function () {
            Route::get('/', Admin\User\IndexController::class)->name(name: 'users');
            Route::patch('{user}', Admin\User\UpdateController::class)->name(name: 'update');
        });
    });
});
