<?php

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
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(prepend: [
            \App\Http\Middleware\JwtFromCookie::class,
        ]);

        $middleware->api(prepend: [
            \App\Http\Middleware\JwtFromCookie::class,
        ]);

        $middleware->encryptCookies(except: [
            'admin_token',
        ]);

        $middleware->redirectTo(
            guests: fn() => '/' . config('app.admin_prefix'),
            users: fn() => '/' . config('app.admin_prefix') . '/dashboard'
        );
        $middleware->alias([
            'permission' => \App\Http\Middleware\CheckPermission::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
