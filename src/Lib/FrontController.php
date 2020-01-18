<?php

namespace Framework\Lib;

use Framework\ServiceProviders\ApplicationServiceProvider;
use Framework\ServiceProviders\ConsoleApplicationServiceProvider;
use Container\ServiceContainer;
use Dotenv\Dotenv;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpCache\Esi;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;
use Symfony\Component\HttpKernel\HttpKernel;

final class FrontController
{
    private static $applicationBasePath;

    public function __construct()
    {
        $this->registerEnv();

        ExceptionHandler::handle();
    }

    /**
     * @param string $applicationBasePath : use dirname(__DIR__) in method call
     * @param array $applicationServiceProviders
     * @param array $commands
     */
    public static function run(string $applicationBasePath, array $applicationServiceProviders = [], array $commands = [])
    {
        self::$applicationBasePath = $applicationBasePath;

        ServiceContainer::getInstance()->register('application_base_path', $applicationBasePath);

        ApplicationServiceProvider::run($applicationServiceProviders);

        if (PHP_SAPI === 'cli') {
            (new self())->runConsole($commands);
        } else {
            (new self())->runHttp();
        }
    }

    private function runConsole(array $commands)
    {
        ConsoleApplicationServiceProvider::run($commands);

        ServiceContainer::getInstance()->service(ConsoleApplication::class)->run();
    }

    private function runHttp()
    {
        // ApplicationRoutes::run(); // TODO add route collection listener to app and to framework

        $app = ServiceContainer::getInstance()->service(HttpKernel::class);

        if (getenv('HTTP_CACHING') == 'true') {
            $app = new HttpCache(
                $app,
                new Store(self::$applicationBasePath . '/storage/cache'),
                new Esi(),
                ['debug' => getenv('APP_DEBUG') == 'true']
            );
        }

        $app
            ->handle(ServiceContainer::getInstance()->service(Request::class))
            ->send();
    }

    private function registerEnv()
    {
        (new Dotenv(self::$applicationBasePath))->load();
    }
}