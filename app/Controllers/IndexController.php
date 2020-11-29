<?php
declare(strict_types=1);

namespace App\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response();
        //return $this->response->setJsonContent(['code' => 0,'msg' => 'success','data' => (object)[]]);
    }

}

