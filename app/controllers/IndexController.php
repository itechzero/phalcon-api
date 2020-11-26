<?php
declare(strict_types=1);

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        return (new \Phalcon\Http\Response())->setJsonContent(['code' => 0,'msg' => 'success','data' => []]);
    }

}

