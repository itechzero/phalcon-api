<?php
declare(strict_types=1);

namespace App\Tasks;

use Phalcon\Cli\Task;

class RabbitMQTask extends Task
{
    public function consumeAction()
    {
        $exchange = 'demo';
        $routeKey = 'demo_queue_key';
        $queue = 'demo_queue';
        $instance = $this->di->getShared('rabbitmq')->instance($exchange, $routeKey, $queue);
        while (true){
            $instance->consumeMsg();
        }
    }

}