<?php

declare(strict_types=1);

use App\Http\Controllers\Api\V1\Admin;
use App\Http\Controllers\Api\V1\Auth;
use App\Http\Controllers\Api\V1\User;
use Illuminate\Support\Facades\Route;
use Spatie\ResponseCache\Middlewares\CacheResponse;

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
 * ADMIN ROUTES
 */
Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::prefix('admin')->as('admin:')->group(function () {
        Route::prefix('users')->as('users:')->group(function () {
            Route::get('/', Admin\User\IndexController::class)->name(name: 'users');
            Route::patch('{user}', Admin\User\UpdateController::class)->name(name: 'update');
        });

        Route::prefix('activities')->as('activities:')->group(function () {
            Route::get('/', Admin\Activity\IndexController::class)->name(name: 'activities');
            Route::post('/', Admin\Activity\StoreController::class)->name(name: 'store');
            Route::patch('{activity}', Admin\Activity\UpdateController::class)->name(name: 'update');
        });
    });
});

/**
 * USER ROUTES
 */
Route::group([
    'middleware' => ['auth:sanctum'],
], function () {
    Route::prefix('user')->as('user:')->group(function () {
        Route::prefix('journals')->as('journals:')->group(function () {
            Route::get('today', User\Journal\TodayJournalController::class)->name(name: 'today');

            Route::post('/', User\Journal\StoreController::class)->name(name: 'store');

            Route::patch('{journal}/gratitude', User\Journal\StoreDailyGratitudeController::class)->name(name: 'gratitude');

            Route::get('/daily-quote', User\GetDailyQuoteController::class)->name(name: 'daily-quote')->middleware(CacheResponse::class);
        });

        Route::prefix('activity')->as('activity:')->group(function () {
            Route::patch('{activity}/count-update', User\Activity\UpdateCountController::class)->name(name: 'count');

            Route::get('/recommendations', User\Activity\ActivityRecommendationsController::class)->name(name: 'recommendations');
        });
    });
});
