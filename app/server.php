<?php

use App\Adapters\Http\HttpAdapter;
use App\Adapters\Injectors\InjectorAdapter;

class Server {

    private HttpAdapter $httpAdapter;

    public function __construct() {
        $this->httpAdapter = InjectorAdapter::get(HttpAdapter::class);

        $this->httpAdapter->initializeServer();
    }

    public function start(){
        $this->httpAdapter->listen();
    }
}
