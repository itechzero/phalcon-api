<?php
declare(strict_types=1);

namespace App\Models\Dao;

use App\Models\User;

class UserDao
{
    public static function userCreate()
    {
        return;
    }


    public static function getUserList()
    {
        return User::find()->toArray();
    }
}