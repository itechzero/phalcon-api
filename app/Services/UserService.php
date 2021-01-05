<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Logic\UserLogic;

class UserService
{
    public static function userCreate()
    {
        return UserLogic::userCreate();
    }

    public static function userList()
    {
        return UserLogic::getUserList();
    }
}