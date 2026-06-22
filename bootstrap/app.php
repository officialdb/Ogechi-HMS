<?php

use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Auth\Middleware\RequirePassword;
use Illuminate\Foundation\Http\Middleware\ValidateCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Middleware\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth'              => \Illuminate\Auth\Middleware\Authenticate::class,
            'can'               => Authorize::class,
            'csrf'              => ValidateCsrfToken::class,
            'guest'             => RedirectIfAuthenticated::class,
            'password.confirm'  => RequirePassword::class,
            'permission'        => PermissionMiddleware::class,
            'role'              => RoleMiddleware::class,
            'role_or_permission'=> RoleOrPermissionMiddleware::class,
            'signed'            => \Illuminate\Routing\Middleware\ValidateSignature::class,
            'throttle'          => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified'          => EnsureEmailIsVerified::class,
            'bindings'          => SubstituteBindings::class,
            'active'            => \App\Http\Middleware\EnsureUserIsActive::class,
        ]);

        // Block deactivated users on every authenticated web request
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureUserIsActive::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
