<?php
declare(strict_types=1);

namespace App\Models\Dao;

use App\Models\UsersProfile;

class UserProfileDao
{
    public static function userProfileCreate(int $uid) :bool
    {
        $userProfile = new UsersProfile();
        $userProfile->setUid($uid);
        return $userProfile->save();
    }
}