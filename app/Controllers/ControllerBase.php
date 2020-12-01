<?php
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{
    // Implement common logic
    public function response($data)
    {
        return $this->response
            ->setJsonContent(
                [
                    'code' => 0,
                    'msg' => 'success',
                    'data' => $data ? $data : (object)[]
                ]
            )
            ->setStatusCode(200,'ok');
    }

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        // This is executed before every found action
        return true;
    }


//    public function afterExecuteRoute($dispatcher)
//    {
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
//    }

}
