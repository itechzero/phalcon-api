<?php
declare(strict_types=1);

use Phalcon\Config;

return new Config(
    [
        'app_env' => 'local',
        'app_debug' => true,
        'version' => 'v1.0',
        'printNewLine' => true,

        'database' => [
            'adapter'     => 'Mysql',
            'host'        => 'mysql',
            'username'    => 'root',
            'password'    => 'secret',
            'dbname'      => 'demo',
            'charset'     => 'utf8',
        ],

        'redis' => [
            'adapter'     => 'phpredis',
            'host'        => 'redis',
            'port'        => 6379,
            'timeout'     => 2.5,
            'auth'        => null,
            'persistent'  => false, //是否持久连接
            'socket'      => '',
            'index'       => 0,
        ],

        'rabbitmq' => [
            'host' => 'rabbitmq',
            'port' => '5672',
            'vhost' => '/',
            'login' => 'guest',
            'password' => 'guest'
        ],
    ]
);