<?php
declare(strict_types=1);

namespace App\Models\Dao;

use App\Models\User;

class UserDao
{
    public static function userCreate()
    {
        $user = new User();
        $user->id = 0;
        //$user->save();
        return $user->save();
    }


    public static function getUserList()
    {
        return User::find()->toArray();
    }
}