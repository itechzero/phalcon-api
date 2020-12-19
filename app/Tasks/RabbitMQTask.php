<?php
declare(strict_types=1);

use Phalcon\Cli\Task;

class RabbitMQTask extends Task
{
    public function consumeAction()
    {
        echo "RabbitMQ consume";
    }
}