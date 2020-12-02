<?php
declare(strict_types=1);

namespace App\Events;

use Exception;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Dispatcher\Exception as DispatcherException;

class ExceptionsEvent extends Injectable
{
    public function beforeException(Event $event, Dispatcher $dispatcher, Exception $exception)
    {
        if ($exception instanceof DispatchException) {
            switch ($exception->getCode()) {
                case DispatcherException::EXCEPTION_HANDLER_NOT_FOUND:
                case DispatcherException::EXCEPTION_ACTION_NOT_FOUND:
                    // 404
                    return $this->response->setJsonContent(
                        [
                            'code' => -2,
                            'msg' => 'route not found',
                            'data' => (object)[],
                        ]
                    );
            }
        }

        return false;
    }
}