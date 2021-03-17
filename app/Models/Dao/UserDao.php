<?php
declare(strict_types=1);

namespace App\Models\Dao;

use App\Models\Users;

class UserDao
{
    public static function userCreate(string $username) :int
    {
        $user = new Users();
        $user->setUsername($username);
        $user->save();
        return (int)$user->getId();
    }


    public static function getUserList()
    {
        return Users::find()->toArray();
    }
}