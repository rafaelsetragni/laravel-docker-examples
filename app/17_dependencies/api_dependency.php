<?php

namespace App\Dependencies;

use App\Adapters\Injectors\InjectorAdapter;
use App\Controllers\V1\Health\HealthV1Controller;
use App\Types\LazyDependency;
use SynistroConfig;

/**
 * Class ApiDependency
 *
 * This class extends PlatformDependency to provide API-specific dependency management.
 */
class ApiDependency extends PlatformDependency {

    protected function step4Configs()
    {
        parent::step4Configs();

        InjectorAdapter::registerSingleton(SynistroConfig::class, function () {
            return new SynistroConfig();
        });
    }

    protected function step15Controllers()
    {
        parent::step15Controllers();

        InjectorAdapter::registerSingleton(HealthV1Controller::class, function() {
            return new HealthV1Controller();
        });
    }
}
