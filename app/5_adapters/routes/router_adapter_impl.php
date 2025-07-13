<?php

namespace App\Adapters\Routes;

use Illuminate\Routing\Route;

class RouterAdapterImpl implements RouterAdapter
{
    public function buildPostRoute(string $routeName, array $controllers): Route
    {
        return Route::post($routeName, ...$controllers);
    }

    public function buildGetRoute(string $routeName, array $controllers): Route
    {
        return Route::get($routeName, ...$controllers);
    }
}
