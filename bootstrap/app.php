<?php

use App\Http\Middleware\ApiJsonResponseMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(ApiJsonResponseMiddleware::class);
        $middleware->trustHosts(at: ['everyday-shops.test']);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
