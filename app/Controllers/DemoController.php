<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Exceptions\BusinessException;
use App\Models\Users;
use App\Validations\IndexValidation;

class DemoController extends ControllerBase
{
    public function indexAction()
    {

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
        $this->di->getShared('rabbitmq')->instance();
    }

}

