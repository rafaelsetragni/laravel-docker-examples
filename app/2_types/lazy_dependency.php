<?php

namespace App\Types;

/**
 * Defines a service that can be initialized via the app:initialize command.
 */
interface LazyDependency
{
    /**
     * Get the initialization priority for this service.
     * Lower numbers are initialized first.
     */
    public function getInitializationStep(): int;

    /**
     * Perform initialization logic.
     */
    public function globalInitialization(): void;

    /**
     * Perform a health check on the service.
     * Should throw an exception if the service is unhealthy.
     */
    public function checkServiceHealthy(): void;
}
