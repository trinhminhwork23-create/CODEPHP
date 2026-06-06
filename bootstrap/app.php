<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin'  => \App\Http\Middleware\CheckAdmin::class,
            'banned' => \App\Http\Middleware\CheckBanned::class,
        ]);
        // NOTE: 'banned' is intentionally NOT appended to the global 'web' group.
        // It is applied selectively via ->middleware('banned') on protected route groups
        // in customer_routes.php. Appending it globally caused CSRF token regeneration
        // on every POST request, silently breaking form submissions with a 419 loop.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();