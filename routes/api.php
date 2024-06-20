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
    Route::post('send-reset-code', Auth\ForgotPasswordCodeGeneratorController::class)->name(name: 'send-reset-code');
    Route::post('reset-password', Auth\ResetPasswordController::class)->name(name: 'reset-password');

    Route::group([
        'middleware' => ['auth:sanctum'],
    ], function () {
        Route::get('profile', Auth\ProfileController::class)->name(name: 'profile');
        Route::post('logout', Auth\LogoutController::class)->name(name: 'logout');
        Route::patch('{user}/update', Auth\UpdateController::class)->name(name: 'update');
        Route::post('{user}/profile/upload', Auth\ProfilePictureUpload::class)->name(name: 'update');
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
            Route::patch('{user}/make-admin', Admin\User\MakeUserAdminController::class)->name(name: 'make-admin');
        });

        Route::prefix('activities')->as('activities:')->group(function () {
            Route::get('/', Admin\Activity\IndexController::class)->name(name: 'activities');
            Route::post('/', Admin\Activity\StoreController::class)->name(name: 'store');
            Route::patch('{activity}', Admin\Activity\UpdateController::class)->name(name: 'update');
            Route::delete('{activity}', Admin\Activity\DeleteController::class)->name(name: 'delete');

            Route::controller(Admin\Activity\ActivityImageController::class)->group(function () {
                Route::post('/{activity}/image', 'uploadImage')->name(name: 'activity-image-upload');
                Route::delete('/{activityImage}/image', 'deleteImage')->name(name: 'activity-image-delete');
            });
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

            Route::get('/weekly-mood', User\Journal\JournalDataFoFeelingGraphController::class)->name(name: 'weekly-mood');
        });

        Route::prefix('activity')->as('activity:')->group(function () {
            Route::patch('{activity}/count-update', User\Activity\UpdateCountController::class)->name(name: 'count');

            Route::get('/recommendations', User\Activity\ActivityRecommendationsController::class)->name(name: 'recommendations');
        });
    });
});
