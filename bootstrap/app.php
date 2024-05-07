<?php

declare(strict_types=1);

use App\Http\Middleware\Cors;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\ResponseCache\Middlewares\CacheResponse;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1',
        // then: function () {
        //    Route::middleware('api')
        //    ->prefix('api/v2')
        //    ->group(base_path('routes/api_v2.php'));
        // }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(Cors::class);
        // $middleware->append(CacheResponse::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
