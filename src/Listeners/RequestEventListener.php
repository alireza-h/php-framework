<?php

namespace Framework\Listeners;

use Framework\Events\BeforeMiddlewareEvent;
use Framework\Lib\Services;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestEventListener implements EventSubscriberInterface
{
    use Services;

    public function onRequest(RequestEvent $event)
    {
        $this->serviceEventDispatcher()->dispatch(new BeforeMiddlewareEvent($event->getRequest()), BeforeMiddlewareEvent::EVENT_FRAMEWORK_BEFORE_REQUEST);
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => 'onRequest'];
    }
}