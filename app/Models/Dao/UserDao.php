<?php
declare(strict_types=1);

namespace App\Models\Dao;

use App\Models\Users;

class UserDao
{
    public static function userCreate()
    {
        $user = new Users();
        $user->setId(0);
        $user->setUsername('hash');

        return $user->save();
    }


    public static function getUserList()
    {
        return Users::find()->toArray();
    }
}