<?php
declare(strict_types=1);

namespace App\Models\Dao;

use App\Models\Users;

class UserDao
{
    /**
     * @return array
     */
    public static function getUserList()
    {
        return Users::find()->toArray();
    }
}