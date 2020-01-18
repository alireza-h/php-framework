<?php

namespace Framework\Listeners;

use Framework\Events\AfterMiddlewareEvent;
use Framework\Lib\Services;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ResponseEventListener implements EventSubscriberInterface
{
    use Services;

    public function onResponse(ResponseEvent $event)
    {
        $this->serviceEventDispatcher()->dispatch(new AfterMiddlewareEvent($event->getResponse(), $event->getRequest()), AfterMiddlewareEvent::EVENT_FRAMEWORK_AFTER_REQUEST);
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::RESPONSE => 'onResponse'];
    }
}