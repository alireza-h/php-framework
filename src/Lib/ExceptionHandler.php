<?php

namespace Framework\Lib;

use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;
use Exception;

class ExceptionHandler
{
    public static function handle()
    {
        if (getenv('APP_ENV') == 'dev' && getenv('APP_DEBUG') == 'true') {
            $whoops = new Run();
            $whoops->appendHandler(new PrettyPageHandler());
            $whoops->register();
        } else {
            set_error_handler([static::class, 'errorHandler']);
            set_exception_handler([static::class, 'exceptionHandler']);
            register_shutdown_function([static::class, 'shutdown']);
        }
    }

    public static function errorHandler($level, $message, $file = null, $line = null)
    {
        echo $message;

        return true;
    }

    public static function exceptionHandler(Exception $exception)
    {
        echo $exception->getMessage();
    }

    public static function shutdown()
    {
        $lastError = error_get_last();

        echo $lastError['message'];

        return true;
    }
}