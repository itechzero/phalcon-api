<?php

/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/../..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return new \Phalcon\Config([
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

    'application' => [
        'appDir'         => APP_PATH . '/',
        'controllersDir' => APP_PATH . '/Controllers/',
        'modelsDir'      => APP_PATH . '/Models/',
        'migrationsDir'  => APP_PATH . '/Migrations/',
        'pluginsDir'     => APP_PATH . '/Plugins/',
        'libraryDir'     => APP_PATH . '/library/',
        'cacheDir'       => BASE_PATH . '/storage/logs/',
        'baseUri'        => '/',
        'migrationsTsBased' => true, // true - Use TIMESTAMP as version name, false - use versions
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
]);
