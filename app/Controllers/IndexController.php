<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Service\UserService;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $redis = $this->di->getShared('redis');

        $requestData = $this->request->get();
        return [
            'list' => UserService::userList(),
            'redis' => $redis->get('phalcon'),
        ];
    }

}

