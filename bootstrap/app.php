<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Hardening response headers on every web request.
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // Send guests hitting protected routes (e.g. the file manager) to the Filament login.
        $middleware->redirectGuestsTo(fn () => route('filament.admin.auth.login'));

        // unisharp/laravel-filemanager doesn't emit a CSRF token in its UI, so its
        // upload/move/delete POSTs fail CSRF ("Invalid upload request"). These routes are
        // already protected by the `auth` middleware, so exempt them from CSRF.
        $middleware->validateCsrfTokens(except: [
            'filemanager/*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
