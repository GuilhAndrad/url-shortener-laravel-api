<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->preventRequestForgery(except: [
            'api/*',
        ]);
        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        $middleware->trustProxies(at: env('TRUSTED_PROXIES', ''));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(function (Request $request, Throwable $e) {
            return $request->is('api/*') || $request->expectsJson();
        });

        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'message' => 'Invalid request data',
                        'errors' => $e->errors(),
                    ], 400);
                }

                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'message' => 'Resource not found',
                    ], 404);
                }

                if ($e instanceof MethodNotAllowedException) {
                    return response()->json([
                        'message' => 'Method not allowed for this route',
                    ], 405);
                }

                return response()->json([
                    'message' => 'An unexpected error occurred.',
                ], 500);
            }
        });
    })->create();
