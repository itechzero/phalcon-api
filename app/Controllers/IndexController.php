<?php
declare(strict_types=1);

namespace App\Controllers;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        return $this->response('welcome phalcon 4');
    }

}

