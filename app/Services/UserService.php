<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Logic\UserLogic;

class UserService
{
    public static function userCreate(string $username)
    {
        return UserLogic::userCreate($username);
    }

    public static function userList()
    {
        return UserLogic::getUserList();
    }
}