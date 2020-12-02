<?php
declare(strict_types=1);

namespace App\Providers;

use App\Listeners\ExceptionsListener;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\Manager as EventsManager;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;

class DispatcherProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'dispatcher',
            function () {
                $eventsManager = new EventsManager();
                $dispatcher = new MvcDispatcher();

                $eventsManager->attach('dispatch:beforeException', new ExceptionsListener, 200);

                $dispatcher->setEventsManager($eventsManager);

                return $dispatcher;
            }
        );
    }
}