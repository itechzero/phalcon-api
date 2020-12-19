<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\BusinessException;
use App\Services\UserService;
use App\Plugins\RabbitMQ;
use App\Validations\IndexValidation;
use App\Models\Users;

class IndexController extends ControllerBase
{

    public function indexAction()
    {
        $redis = $this->di->getShared('redis');

        $requestData = $this->request->get();

        $validation = new IndexValidation();
        if (!($validation->validate($requestData))) {
            throw new BusinessException(BusinessException::HTTP_API_ERROR, $validation->validate($requestData));
        }

        return [
            'list' => UserService::userList(),
            'redis' => $redis->get('phalcon'),
        ];
    }

    public function showAction($id)
    {
        $builder = $this
            ->modelsManager
            ->createBuilder()
            ->addFrom(Users::class, 'u')
            ->where('u.id = :user_id:',
                [
                    'user_id' => $id,
                ])
            ->columns(['name', 'email'])
            ->getQuery();
        return $builder->getSingleResult()->toArray();
    }

    public function mqAction()
    {
        $this->di->getShared('rabbitmq');
    }

}

