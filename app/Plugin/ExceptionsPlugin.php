<?php
declare(strict_types=1);

namespace App\Plugin;

use Exception;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class ExceptionsPlugin
{
    public function beforeException(Event $event,Dispatcher $dispatcher,Exception $exception)
    {
        if ($exception instanceof DispatchException) {
            // TODO
        }
    }
}