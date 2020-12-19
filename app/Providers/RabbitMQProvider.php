<?php
declare(strict_types=1);

namespace App\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use App\Plugins\RabbitMQ;

class RabbitMQProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'rabbitmq',
            function () use ($di) {
                return new RabbitMQ($di);
            }
        );
    }
}