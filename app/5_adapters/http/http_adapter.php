<?php

namespace App\Adapters\Http;

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

class HttpAdapter
{
    private Application $app;

    public function initializeServer(
        array $globalMiddlewares = [],
        array $routers = []
    ): void
    {
        $this->app = Application::configure(basePath: dirname(__DIR__, 2))
            ->withRouting(
                web: base_path('routes/web.php'),
                commands: base_path('routes/console.php'),
                health: '/up',
            )
            ->withMiddleware(function (Middleware $middleware) use ($globalMiddlewares, $applicationErrorHandler, $notFoundHandler) {
                foreach ($globalMiddlewares as $mw) {
                    $middleware->append($mw);
                }
                if ($applicationErrorHandler) {
                    $middleware->append($applicationErrorHandler);
                }
                if ($notFoundHandler) {
                    $middleware->append($notFoundHandler);
                }
            })
            ->withExceptions(function (Exceptions $exceptions) {
                // Optional: customize exception rendering
            })
            ->create();

        foreach ($routers as $path => $middlewares) {
            Route::middleware(array_filter([$localizationMiddleware, ...$middlewares]))
                ->prefix($path)
                ->group(function () use ($middlewares) {
                    foreach ($middlewares as $middleware) {
                        // Example: You can define routes here if needed
                        // Route::get('/example', $middleware);
                    }
                });
        }
    }

    public function listen(){
        $this->app->handleRequest(Request::capture());
    }
}
