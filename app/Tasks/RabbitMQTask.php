<?php
declare(strict_types=1);

namespace App\Tasks;

class RabbitMQTask extends AbstractTask
{
    public function mainAction()
    {
        $exchange = 'demo';
        $routeKey = 'demo_queue_key';
        $queue = 'demo_queue';
        $instance = $this->di->getShared('rabbitmq')->instance($exchange, $routeKey, $queue);
        while (true){
            $instance->consumeMsg();
        }
    }

    public function runAction()
    {
        // TODO: Implement runAction() method.
    }
}