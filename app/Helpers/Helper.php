<?php
declare(strict_types=1);

namespace App\Helpers;

use App\Plugins\RabbitMQ;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Logger;
use Redis;
use Phalcon\Di;

/**
 * Class Helper
 * @package App\Helpers
 */
class Helper
{

    public static function getDI()
    {
        return Di::getDefault();
    }

    /**
     * @return Redis
     */
    public static function getRedis(): Redis
    {
        return self::getDI()->getShared('redis');
    }

    /**
     * @return RabbitMQ
     */
    public static function getRabbitMQ(): RabbitMQ
    {
        return self::getDI()->getShared('rabbitmq');
    }

    /**
     * @return Logger
     */
    public static function getLogger(): Logger
    {
        return self::getDI()->getShared('logger');
    }

    /**
     * @return Mysql
     */
    public static function getDB(): Mysql
    {
        return self::getDI()->getShared('db');
    }

}