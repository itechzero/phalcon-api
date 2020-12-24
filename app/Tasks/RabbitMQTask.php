<?php
declare(strict_types=1);

namespace App\Tasks;

use Phalcon\Cli\Task;

class RabbitMQTask extends Task
{
    public function consumeAction()
    {
        $this->di->getShared('rabbitmq')->instance();
//        $queue->consume(function ($event, $queue) {
//            $body = $event->getBody();
//            var_dump($body);
//
//            $queue->ack($event->getDeliveryTag());
//        });
    }
}