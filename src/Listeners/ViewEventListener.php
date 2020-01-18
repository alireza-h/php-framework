<?php
namespace Framework\Listeners;

use Framework\Lib\Services;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ViewEventListener implements EventSubscriberInterface
{
    use Services;

    public function onView(ViewEvent $event)
    {
        $controllerResult = $event->getControllerResult();
        if (is_array($controllerResult)) {
            $event->setResponse(new JsonResponse($controllerResult));
        } elseif (is_object($controllerResult)) {
            $event->setResponse(new JsonResponse($controllerResult));
        } elseif (is_string($controllerResult)) {
            $event->setResponse(new Response($controllerResult));
        } elseif (is_numeric($controllerResult)) {
            $event->setResponse(new Response($controllerResult));
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onView', 100]
        ];
    }
}
