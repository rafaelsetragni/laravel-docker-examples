<?php

namespace App\Adapters\Routes;

use Illuminate\Routing\Route;

interface RouterAdapter
{
    /**
     * Adds a POST route with one or more controller actions.
     *
     * @param string $routeName
     * @param array $controllers
     * @return Route
     */
    public function buildPostRoute(string $routeName, array $controllers): Route;

    /**
     * Adds a GET route with one or more controller actions.
     *
     * @param string $routeName
     * @param array $controllers
     * @return Route
     */
    public function buildGetRoute(string $routeName, array $controllers): Route;
}
