<?php
declare(strict_types=1);

namespace App\Controllers;

use Phalcon\Http\Response;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        return (new Response())->setJsonContent(['code' => 0,'msg' => 'success','data' => (object)[]]);
    }

}

