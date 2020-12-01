<?php
declare(strict_types=1);

namespace App\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $data = ['num' => 2333];
        return $this->response($data);
        //return $this->response->setJsonContent(['code' => 0,'msg' => 'success','data' => (object)[]]);
    }



}

