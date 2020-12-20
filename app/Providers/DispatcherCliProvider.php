<?php
declare(strict_types=1);

namespace App\Providers;

use Phalcon\Cli\Dispatcher;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class DispatcherCliProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'dispatcher',
            function () {
                $dispatcher = new Dispatcher();
                $dispatcher->setDefaultNamespace('App\\Tasks');
                return $dispatcher;
            }
        );
    }
}