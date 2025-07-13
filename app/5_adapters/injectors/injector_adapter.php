<?php

namespace App\Adapters\Injectors;

use App\Adapters\Injectors\InjectorAdapterImpl;

use Closure;

interface InjectorAdapterContract
{
    /**
     * Sets the current registration layer.
     */
    public function registerLayer(int $layer): void;

    /**
     * Registers a singleton factory without creating an instance.
     *
     * @template T of object
     * @param class-string<T> $typeClass
     * @param Closure(): T $factory
     */
    public function registerSingleton(string $typeClass, Closure $factory): void;

    /**
     * Registers a normal (non-singleton) factory.
     *
     * @template T of object
     * @param class-string<T> $typeClass
     * @param Closure(): T $factory
     */
    public function registerFactory(string $typeClass, Closure $factory): void;

    /**
     * Gets an instance of the requested type.
     *
     * @template T of object
     * @param class-string<T> $typeClass
     * @return T
     */
    public function get(string $typeClass, mixed $params = null, mixed $extras = null): mixed;

    public function globalInitialize(): void;

    public function checkAllServicesHealthy(): void;
}

final class InjectorAdapter
{
    private static ?InjectorAdapterContract $instance = null;

    public static function setInstance(InjectorAdapterContract $customInstance): void
    {
        self::$instance = $customInstance;
    }

    private static function getInstance(): InjectorAdapterContract
    {
        if (self::$instance === null) {
            throw new \RuntimeException('InjectorAdapter instance has not been set.');
        }
        return self::$instance;
    }

    public static function registerLayer(int $layer): void
    {
        self::getInstance()->registerLayer($layer);
    }

    public static function registerSingleton(string $typeClass, Closure $factory): void
    {
        self::getInstance()->registerSingleton($typeClass, $factory);
    }

    public static function registerFactory(string $typeClass, Closure $factory): void
    {
        self::getInstance()->registerFactory($typeClass, $factory);
    }

    public static function get(string $typeClass, mixed $params = null, mixed $extras = null): mixed
    {
        return self::getInstance()->get($typeClass, $params, $extras);
    }

    public static function globalInitialize(): void
    {
        self::getInstance()->globalInitialize();
    }

    public static function checkAllServicesHealthy(): void
    {
        self::getInstance()->checkAllServicesHealthy();
    }
}
