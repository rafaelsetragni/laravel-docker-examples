<?php

namespace App\Routes;

use App\Adapters\Injectors\InjectorAdapter;
use App\Routes\Routes;
use App\Constants\RoutePath;
use App\Controllers\V1\Health\HealthV1Controller;

class V1Routes extends RouterContract {

    private HealthV1Controller $healthController;

    public function __construct() {
        $this->healthController = InjectorAdapter::get(HealthV1Controller::class);
    }

    public function getRoutes() : array {

        return [
            // Health Status API
            $this->addGetRoute(RoutePath::HEALTH_PING, [
                $this->healthController->ping(),
            ]),
        ];
    }
}
