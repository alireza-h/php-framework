<?php

namespace Framework\ServiceProviders;

use Framework\Lib\ServiceProvider;
use Framework\Listeners\RequestEventListener;
use Framework\Listeners\ResponseEventListener;
use Framework\Listeners\ViewEventListener;
use Symfony\Component\HttpKernel\EventListener\RouterListener;

class EventServiceProvider extends ServiceProvider
{
    private $dispatcher;

    private $eventListeners = [
        /*ResponseEvent::EVENT_APP_RESPONSE => [
            [
                'callback' => [ResponseEventListener::class, 'handle'],
                'priority' => 255
            ],
            [
                'callback' => [ResponseEventListener::class, 'toLower'],
                'priority' => 230
            ],
            [
                'callback' => [ResponseEventListener::class, 'toUpper'],
                'priority' => 240
            ],
        ]*/
    ];

    private $eventSubscribers = [
        ViewEventListener::class,
        RequestEventListener::class,
        ResponseEventListener::class,
    ];

    public function __construct()
    {
        $this->dispatcher = $this->serviceEventDispatcher();
    }

    public function boot()
    {
        $this->registerEvents();
    }

    private function registerEvents()
    {
        foreach ($this->eventListeners as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->dispatcher->addListener($event, $listener['callback'], $listener['priority'] ?? 0);
            }
        }

        foreach ($this->eventSubscribers as $subscriber) {
            $this->dispatcher->addSubscriber(new $subscriber);
        }

        $this->dispatcher->addSubscriber($this->service(RouterListener::class));
    }
}