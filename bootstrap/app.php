<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Validation\ValidationException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $e, Request $request) {
            if ($request->is('api/*')) {

                if ($e instanceof NotFoundHttpException) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Resource not found.',
                        'data' => null,
                    ], 404);
                }

                if ($e instanceof ValidationException) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validation failed.',
                        'errors' => $e->validator->errors(),
                    ], 422);
                }



                // Handle other exceptions
                return response()->json([
                    'status' => false,
                    'message' => 'An unexpected error occurred.',
                    'data' => null,
                ], 500);
            }


            return parent::render($request, $e);
        });
    })->create();
