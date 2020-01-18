<?php

namespace Framework\ServiceProviders;

use Framework\Lib\ServiceProvider;
use Framework\Services\PathService;
use Framework\Services\UrlService;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

final class ApplicationServiceProvider extends ServiceProvider
{
    private static $applicationServiceProviders;

    private $serviceProviders = [
        EventServiceProvider::class,
    ];

    private function __construct()
    {
    }

    public static function run(array $applicationServiceProviders)
    {
        self::$applicationServiceProviders = $applicationServiceProviders;

        (new self)
            ->boot()
            ->bootServiceProviders();
    }

    public function boot()
    {
        $this
            ->registerService(EventDispatcher::class)
            ->registerService(Session::class)
            ->registerService(Request::class, function ($container) {
                $request = Request::createFromGlobals();
                $request->setSession($container[Session::class]);
                return $request;
            })
            ->registerService(RouteCollection::class)
            ->registerService(RequestContext::class)
            ->registerService(UrlMatcher::class, null, RouteCollection::class, RequestContext::class)
            ->registerService(RequestStack::class)
            ->registerService(RouterListener::class, null, UrlMatcher::class, RequestStack::class, RequestContext::class)
            ->registerService(ControllerResolver::class)
            ->registerService(ArgumentMetadataFactory::class)
            ->registerService(ArgumentResolver::class, null, ArgumentMetadataFactory::class)
            ->registerService(HttpKernel::class, null, EventDispatcher::class, ControllerResolver::class, RequestStack::class, ArgumentResolver::class)
            ->registerService(PathService::class)
            ->registerService(UrlService::class, null, RouteCollection::class, RequestContext::class);

        return $this;
    }

    private function bootServiceProviders()
    {
        foreach (array_merge($this->serviceProviders, self::$applicationServiceProviders) as $serviceProvider) {
            (new $serviceProvider())->boot();
        }
    }
}