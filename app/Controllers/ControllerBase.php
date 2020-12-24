<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\BaseException;
use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    /**
     * @param array $data
     * @param string $msg
     * @return \Phalcon\Http\ResponseInterface
     */
    public function response(string $msg = 'success',array $data = []):\Phalcon\Http\ResponseInterface
    {
        return $this->response
            ->setJsonContent(
                [
                    'code' => 0,
                    'msg' => $msg,
                    'data' => $data ? (object)$data : (object)[]
                ]
            )
            ->setStatusCode(BaseException::HTTP_OK,'ok');
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        // This is executed before every found action
        return true;
    }


    public function afterExecuteRoute($dispatcher)
    {
//        $this->view->disable();
//        $this->response->setContentType('application/json', 'UTF-8');
//        $this->response->setHeader('Cache-Control', 'no-store');
//
//        /** @var array $data */
//        $data = $dispatcher->getReturnedValue();
//        $dispatcher->setReturnedValue([]);
//
//        if (true !== $this->response->isSent()) {
//            $this->response->setJsonContent($data);
//            return $this->response->send();
//        }
    }

}
