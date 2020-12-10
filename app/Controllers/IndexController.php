<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\BusinessException;
use App\Service\UserService;
use App\Validations\IndexValidation;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $redis = $this->di->getShared('log');

        $requestData = $this->request->get();

        $validation = new IndexValidation();
        if (!($validation->validate($requestData))) {
            throw new BusinessException(BusinessException::HTTP_API_ERROR,$validation->validate($requestData));
        }

        return [
            'list' => UserService::userList(),
            'redis' => $redis->get('phalcon'),
        ];
    }

}

