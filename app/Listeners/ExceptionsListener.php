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
        //dd(get_class($exception));
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

        $this->response->setJsonContent($params)->setStatusCode(BaseException::HTTP_INTERNAL_SERVER_ERROR);

        if ($exception instanceof DispatchException) {
            switch ($exception->getCode()) {
                case DispatcherException::EXCEPTION_HANDLER_NOT_FOUND:
                case DispatcherException::EXCEPTION_ACTION_NOT_FOUND:
                    $params['code'] = BaseException::HTTP_NOT_FOUND;
                    $params['msg'] = BaseException::$statusTexts[BaseException::HTTP_NOT_FOUND];
                    $this->response->setJsonContent($params)->setStatusCode(BaseException::HTTP_NOT_FOUND);
                    break;
                default:
                    $this->di->getShared('log')->error($exception->getTraceAsString());
                    break;
            }
        }

        if ($exception instanceof BaseException) {
            $params['code'] = $exception->getCode();
            $params['msg'] = $params['msg'] ? $params['msg'] : BaseException::$statusTexts[BaseException::HTTP_INTERNAL_SERVER_ERROR];
            $this->response->setJsonContent($params)->setStatusCode($exception::getStatusCode($exception->getCode()));
        }

        $this->di->getShared('log')->error($exception->getTraceAsString());

        $dispatcher->setReturnedValue($this->response);
        return false;
    }
}