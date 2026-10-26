<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // A stale contact form (expired session, or a login in another tab) should not dead-end on a 419 page.
        $exceptions->render(function (HttpException $e, Request $request) {
            if ($e->getStatusCode() === 419 && $request->routeIs('contact')) {
                return redirect()->to(route('home').'#contact')
                    ->withInput($request->except('_token'))
                    ->with('contact_expired', true);
            }
        });
    })->create();
