<?php

namespace Framework\Lib;

abstract class ServiceProvider
{
    use Services;

    public abstract function boot();
}