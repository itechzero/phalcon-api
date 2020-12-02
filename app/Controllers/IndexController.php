<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Service\UserService;

class IndexController extends ControllerBase
{

    public function indexAction()
    {

        $requestData = $this->request->get();
        return [
            'list' => UserService::userList(),
        ];
    }

}

