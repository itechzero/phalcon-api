<?php
declare(strict_types=1);

namespace App\Models\Logic;

use App\Models\Dao\UserDao;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email as EmailValidator;

class UserLogic
{
    public function validation()
    {
//        $validator = new Validation();
//
//        $validator->add(
//            'username',
//            new EmailValidator(
//                [
//                    'model' => $this,
//                    'message' => 'Please enter a correct email address',
//                ]
//            )
//        );
//
//        return $this->validate($validator);
    }

    public static function userCreate()
    {
        return UserDao::userCreate();
    }

    public static function getUserList()
    {
        return UserDao::getUserList();
    }

}