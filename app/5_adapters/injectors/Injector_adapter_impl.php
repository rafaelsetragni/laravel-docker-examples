<?php

namespace App\Adapters\Injectors;

use Illuminate\Support\Facades\Log;
use RuntimeException;

use App\Types\LazyDependency;

use Closure;

class InjectorAdapterImpl implements InjectorAdapterContract
{
    private int $currentStep = 0;
    /**
     * @var array<int, array{class: string, singleton: bool}>
     * Structure: [ [ 'class' => FQCN, 'layer' => int, 'singleton' => bool ], ... ]
     */
    private array $registeredDependencies = [];

    public function registerLayer(int $layer): void
    {
        $this->currentStep = $layer;
        Log::info("\n🧱 [Injector] Registering Layer {$layer}");
    }

    public function registerSingleton(string $typeClass, Closure $factory): void
    {
        app()->singleton($typeClass, $factory);
        Log::info("✅ [Injector] Registered Singleton: {$typeClass} (Layer {$this->currentStep})");
        $this->registeredDependencies[] = [
            'class' => $typeClass,
            'layer' => $this->currentStep,
            'singleton' => true,
        ];
    }

    public function registerFactory(string $typeClass, Closure $factory): void
    {
        app()->bind($typeClass, $factory);
        Log::info("✅ [Injector] Registered Factory: {$typeClass} (Layer {$this->currentStep})");
        $this->registeredDependencies[] = [
            'class' => $typeClass,
            'layer' => $this->currentStep,
            'singleton' => false,
        ];
    }

    public function get(string $typeClass, mixed $params = null, mixed $extras = null): mixed
    {
        return app()->make($typeClass, (array) $params);
    }

    public function globalInitialize(): void
    {
        Log::info("\n🚀 [Injector] Starting Global Initialization...");

        // Group dependencies by layer
        $byLayer = [];
        foreach ($this->registeredDependencies as $dep) {
            $byLayer[$dep['layer']][] = $dep;
        }
        ksort($byLayer); // Ascending layer order
        foreach ($byLayer as $layer => $deps) {
            foreach ($deps as $dep) {
                try {
                    $instance = app()->make($dep['class']);
                    if ($instance instanceof LazyDependency) {
                        // This will call the constructor and trigger initialization if needed
                        // No-op: just instantiate to trigger initialization
                    }
                } catch (\Throwable $e) {
                    Log::warning("⚠️ [Injector] Failed to initialize {$dep['class']} (Layer $layer): {$e->getMessage()}");
                }
            }
        }
        Log::info("\n✅ [Injector] Global initialization completed.");
    }

    public function checkAllServicesHealthy(): void
    {
        Log::info("\n💖 [Injector] Starting Service Health Checks...");

        // Group dependencies by layer
        $byLayer = [];
        foreach ($this->registeredDependencies as $dep) {
            $byLayer[$dep['layer']][] = $dep;
        }
        ksort($byLayer); // Ascending layer order
        foreach ($byLayer as $layer => $deps) {
            foreach ($deps as $dep) {
                try {
                    $instance = app()->make($dep['class']);
                    if ($instance instanceof LazyDependency) {
                        try {
                            $instance->checkServiceHealthy();
                        } catch (\Throwable $e) {
                            Log::warning("⚠️ [Injector] Service health check failed for {$dep['class']} (Layer $layer): {$e->getMessage()}");
                        }
                    }
                } catch (\Throwable $e) {
                    Log::warning("⚠️ [Injector] Failed to instantiate {$dep['class']} (Layer $layer) for health check: {$e->getMessage()}");
                }
            }
        }
        Log::info("\n✅ [Injector] Service health checks completed.");
    }
}
