<?php
declare(strict_types=1);

namespace App\Service;

use App\Models\Dao\UserDao;

class UserService
{
    public static function userList()
    {
        return UserDao::getUserList();
    }
}