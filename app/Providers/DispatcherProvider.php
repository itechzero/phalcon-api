<?php
declare(strict_types=1);

namespace App\Providers;

use App\Events\ExceptionsEvent;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\Manager as EventsManager;

class DispatcherProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di)
    {
        $di->setShared(
            'dispatcher',
            function () {
                $eventsManager = new EventsManager();

                $eventsManager->attach('dispatch:beforeException',(new ExceptionsEvent),200);
            }
        );
    }
}