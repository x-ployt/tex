<?php

use App\Http\Middleware\AdminOnly;
use App\Http\Middleware\RiderOnly;
use App\Http\Middleware\SuperAdminOnly;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'SuperAdminOnly' => SuperAdminOnly::class,
            'AdminOrSuperAdmin' => AdminOnly::class,
            'AdminOnly' => AdminOnly::class,
            'RiderOnly' => RiderOnly::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
