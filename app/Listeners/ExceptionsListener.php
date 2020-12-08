<?php
declare(strict_types=1);

namespace App\Listeners;

use App\Exceptions\BaseException;
use Exception;
use Phalcon\Di\Injectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher as MvcDispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;
use Phalcon\Dispatcher\Exception as DispatcherException;

class ExceptionsListener extends Injectable
{
    public function beforeException(Event $event, MvcDispatcher $dispatcher, Exception $exception)
    {
        if ($exception instanceof Exception) {
            $this->response->setJsonContent(
                [
                    'code' => -1,
                    'msg' => $exception->getTrace(),
                    'data' => (object)[],
                ]
            );
        }

        if ($exception instanceof DispatchException) {
            switch ($exception->getCode()) {
                case DispatcherException::EXCEPTION_HANDLER_NOT_FOUND:
                case DispatcherException::EXCEPTION_ACTION_NOT_FOUND:
                    // 404
                    $this->response->setJsonContent(
                        [
                            'code' => -2,
                            'msg' => 'route not found',
                            'data' => (object)[],
                        ]
                    );
                    break;
                default:
//                    $this->logger->error($ex->getMessage());
//                    $this->logger->error($ex->getTraceAsString());
                    break;
            }
        }

        if ($exception instanceof BaseException) {
            $this->response->setJsonContent(
                [
                    'code' => -3,
                    'msg' => $exception->getTrace(),
                    'data' => (object)[],
                ]
            );
        }


        $dispatcher->setReturnedValue($this->response);
        return false;
    }
}