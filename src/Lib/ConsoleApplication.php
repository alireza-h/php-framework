<?php

namespace Framework\Lib;


use Symfony\Component\Console\Application;

class ConsoleApplication extends Application
{
    use Services;

    public function __construct()
    {
        parent::__construct();

        $this->setDispatcher($this->serviceEventDispatcher());
    }
}