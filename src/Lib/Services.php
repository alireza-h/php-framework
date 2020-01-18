<?php

namespace Framework\Lib;

use Container\ServiceContainer;
use Framework\Services\PathService;
use Framework\Services\UrlService;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\RouteCollection;

trait Services
{
    public function serviceEventDispatcher(): EventDispatcher
    {
        return $this->service(EventDispatcher::class);
    }

    public function serviceSession(): Session
    {
        return $this->service(Session::class);
    }

    public function serviceRequest(): Request
    {
        return $this->service(Request::class);
    }

    public function servicePath(): PathService
    {
        return $this->service(PathService::class);
    }

    public function serviceRouteCollection(): RouteCollection
    {
        return $this->service(RouteCollection::class);
    }

    public function serviceUrl(): UrlService
    {
        return $this->service(UrlService::class);
    }

    public function getContainer()
    {
        return ServiceContainer::getInstance();
    }

    protected function registerService(string $key, $value = null, ...$args)
    {
        $this->getContainer()->register($key, $value, $args);

        return $this;
    }

    protected function service($service = null, $factory = false)
    {
        return $this->getContainer()->service($service, $factory);
    }
}