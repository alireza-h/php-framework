<?php

namespace Framework\ServiceProviders;

use Framework\Lib\ConsoleApplication;
use Framework\Lib\ServiceProvider;

final class ConsoleApplicationServiceProvider extends ServiceProvider
{
    // TODO : implement lazy registration
    private static $commands;

    private function __construct()
    {
    }

    public static function run(array $commands)
    {
        self::$commands = $commands;

        (new self())->boot();
    }

    public function boot()
    {
        $this
            ->registerService(ConsoleApplication::class);

        $this->registerCommands();
    }

    private function registerCommands()
    {
        /** @var ConsoleApplication $consoleApplication */
        $consoleApplication = $this->service(ConsoleApplication::class);

        foreach (self::$commands as $command) {
            $consoleApplication->add(new $command);
        }
    }
}