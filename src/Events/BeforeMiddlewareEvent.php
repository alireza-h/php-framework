<?php

namespace Framework\Events;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\EventDispatcher\Event;

class BeforeMiddlewareEvent extends Event
{
    public const EVENT_FRAMEWORK_BEFORE_REQUEST = 'framework.before.request';

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest()
    {
        return $this->request;
    }
}