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
        $params = [
            'code' => BaseException::HTTP_INTERNAL_SERVER_ERROR,
            'msg' => $exception->getMessage() ? $exception->getMessage() : BaseException::$statusTexts[BaseException::HTTP_INTERNAL_SERVER_ERROR],
            'data' => (object)[],
        ];

        if ($this->di->getShared('config')->app_debug) {
            $params['trace'] = $exception->getTrace();
            $params['file'] = $exception->getFile();
            $params['line'] = $exception->getLine();
        }

        if ($exception instanceof DispatchException) {
            switch ($exception->getCode()) {
                case DispatcherException::EXCEPTION_HANDLER_NOT_FOUND:
                case DispatcherException::EXCEPTION_ACTION_NOT_FOUND:
                    $params['code'] = BaseException::HTTP_NOT_FOUND;
                    $params['msg'] = BaseException::$statusTexts[BaseException::HTTP_NOT_FOUND];
                    $this->response->setJsonContent($params)->setStatusCode(BaseException::HTTP_NOT_FOUND);
                    break;
                default:
//                    $this->logger->error($ex->getMessage());
//                    $this->logger->error($ex->getTraceAsString());
                    break;
            }
        }

        if ($exception instanceof Exception) {
            $this->response->setJsonContent($params)->setStatusCode(BaseException::HTTP_INTERNAL_SERVER_ERROR);
        }

        $this->di->getShared('log')->error($exception->getTraceAsString());

        $dispatcher->setReturnedValue($this->response);
        return false;
    }
}