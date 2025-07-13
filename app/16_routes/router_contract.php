<?php

namespace App\Routes;

use App\Adapters\Injectors\InjectorAdapter;
use App\Adapters\Routes\RouterAdapter;
use Illuminate\Routing\Route;

abstract class RouterContract {

    private RouterAdapter $routerAdapter;

    public function __construct() {
        $this->routerAdapter = InjectorAdapter::get(RouterAdapter::class);
    }

    public abstract function getRoutes() : array;

    protected function addPostRoute(string $path, array $controllers): Route {
        return $this->routerAdapter->buildPostRoute($path, $controllers);
    }

    protected function addGetRoute(string $path, array $controllers): Route {
        return $this->routerAdapter->buildGetRoute($path, $controllers);
    }

}
