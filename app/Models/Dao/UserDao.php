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
        $user->username = 'hash';
        $result = $user->save();
        if (false === $result) {

            echo 'Error saving Invoice: ';

            $messages = $user->getMessages();

            foreach ($messages as $message) {
                echo $message . PHP_EOL;
            }
        } else {

            echo 'Record Saved';
        }

        //return $user->save();
    }


    public static function getUserList()
    {
        return User::find()->toArray();
    }
}