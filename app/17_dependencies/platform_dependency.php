<?php

namespace App\Dependencies;

use App\Adapters\Injectors\InjectorAdapter;

abstract class PlatformDependency {

    /**
     * PlatformDependency constructor.
     *
     * @param string $platform
     */
    public function __construct($injector, $routes, $onFinished) {
        InjectorAdapter::setInstance($injector);
        $this->setFactories();
    }

    /**
     * Get the platform name.
     *
     * @return string
     */
    private function setFactories() {
        $this->step1Constants();
        $this->step2Types();
        $this->step3Utils();
        $this->step4Configs();
        $this->step5Adapters();
        $this->step6Localizations();
        $this->step7ValueObjects();
        $this->step8Models();
        $this->step9States();
        $this->step10Apis();
        $this->step11Repositories();
        $this->step12Domains();
        $this->step13UseCases();
        $this->step14Presenters();
        $this->step15Controllers();
        $this->step16Routes();
    }

    protected function step1Constants() {
        InjectorAdapter::registerLayer(1);
    }

    protected function step2Types() {
        InjectorAdapter::registerLayer(2);
    }

    protected function step3Utils() {
        InjectorAdapter::registerLayer(3);
    }

    protected function step4Configs() {
        InjectorAdapter::registerLayer(4);
    }

    protected function step5Adapters() {
        InjectorAdapter::registerLayer(5);
    }

    protected function step6Localizations() {
        InjectorAdapter::registerLayer(6);
    }

    protected function step7ValueObjects() {
        InjectorAdapter::registerLayer(7);
    }

    protected function step8Models() {
        InjectorAdapter::registerLayer(8);
    }

    protected function step9States() {
        InjectorAdapter::registerLayer(9);
    }

    protected function step10Apis() {
        InjectorAdapter::registerLayer(10);
    }

    protected function step11Repositories() {
        InjectorAdapter::registerLayer(11);
    }

    protected function step12Domains() {
        InjectorAdapter::registerLayer(12);
    }

    protected function step13UseCases() {
        InjectorAdapter::registerLayer(13);
    }

    protected function step14Presenters() {
        InjectorAdapter::registerLayer(14);
    }

    protected function step15Controllers() {
        InjectorAdapter::registerLayer(15);
    }

    protected function step16Routes() {
        InjectorAdapter::registerLayer(16);
    }
}
