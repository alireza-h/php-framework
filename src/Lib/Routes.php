<?php

namespace Framework\Lib;

use Container\ServiceContainer;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

trait Routes
{
    public function addRoute(
        string $path,
        string $controller,
        string $action,
        array $defaults = [],
        array $requirements = []
    ) {
        return $this->add(
            "$controller::$action",
            $path,
            $this->getDefaults($controller, $action, $defaults),
            $requirements
        );
    }

    public function addNamedRoute(
        string $name,
        string $path,
        string $controller,
        string $action,
        array $defaults = [],
        array $requirements = []
    ) {
        return $this->add(
            $name,
            $path,
            $this->getDefaults($controller, $action, $defaults),
            $requirements
        );
    }

    public function add(
        string $name,
        string $path,
        array $defaults = [],
        array $requirements = [],
        array $options = [],
        ?string $host = '',
        $schemes = [],
        $methods = [],
        ?string $condition = ''
    ): self
    {
        ServiceContainer::getInstance()->service(RouteCollection::class)->add(
            $name,
            new Route($path, $defaults, $requirements, $options, $host, $schemes, $methods, $condition)
        );

        return $this;
    }

    private function getDefaults(string $controller, string $action, array $defaults = []): array
    {
        return array_merge(
            [
                '_controller' => "$controller::$action",
            ],
            $defaults
        );
    }
}