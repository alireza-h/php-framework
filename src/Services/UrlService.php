<?php

namespace Framework\Services;

use Framework\Lib\Services;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

class UrlService extends UrlGenerator
{
    use Services;

    public function __construct(RouteCollection $routes, RequestContext $context)
    {
        parent::__construct($routes, $context);
    }

    public function route($name, $parameters = [], $referenceType = self::ABSOLUTE_URL): string
    {
        return parent::generate($name, $parameters, $referenceType);
    }

    public function url(string $controller, string $action, $parameters = [], $referenceType = self::ABSOLUTE_URL): string
    {
        return $this->route($this->getRouteName($controller, $action), $parameters, $referenceType);
    }

    public function getRouteName(string $controller, string $action): string
    {
        return "$controller::$action";
    }

    public function routes(): array
    {
        return $this->routes->all();
    }
}