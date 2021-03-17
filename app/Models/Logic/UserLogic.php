<?php
declare(strict_types=1);

namespace App\Models\Logic;

use App\Exceptions\BusinessModelException;
use App\Helpers\Helper;
use App\Models\Dao\UserDao;
use App\Models\Dao\UserProfileDao;
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

    public static function userCreate(string $username)
    {
        try {
            $db = Helper::getDB();
            $db->begin();
            $uid = UserDao::userCreate($username);
            if (is_null($uid)) {
                throw new BusinessModelException(20001);
            }
            $result = UserProfileDao::userProfileCreate($uid);
            $db->commit();
        }catch (BusinessModelException $exception){
            $result = false;
            $db->rollback();
        }
        return $result;
    }

    public static function getUserList()
    {
        return UserDao::getUserList();
    }

}