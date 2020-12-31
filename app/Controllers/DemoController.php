<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\BusinessException;
use App\Models\Users;
use App\Services\UserService;
use App\Validations\IndexValidation;

class DemoController extends ControllerBase
{
    public function indexAction()
    {
        return UserService::userList();
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

    public function validateAction()
    {
        $requestData = $this->request->get();

        $validation = new IndexValidation();
        if (!($validation->validate($requestData))) {
            throw new BusinessException(BusinessException::HTTP_API_ERROR, $validation->validate($requestData));
        }
    }

    public function redisAction()
    {
        $redis = $this->di->getShared('redis');
        dd($redis->get('phalcon'));
    }

    public function mqAction()
    {
        $exchange = 'demo';
        $routeKey = 'demo_queue_key';
        $queue = 'demo_queue';

        $msg = [
            'username' => 'zhangsan',
            'device' => '862986040837632',
            'channel' => 'android_weixin',
            'created_at' => time(),
        ];

        $this->di->getShared('rabbitmq')
            ->instance($exchange, $routeKey, $queue)
            ->sendMsg(json_encode($msg));
    }

}

