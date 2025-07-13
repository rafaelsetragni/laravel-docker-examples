<?php

namespace App\Controllers\V1\Health;

abstract class HealthV1Controller
{
    public abstract function ping(): \Closure;
}
