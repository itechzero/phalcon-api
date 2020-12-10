<?php
declare(strict_types=1);

namespace App\Providers;

use PDO;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class DbProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'db',
            function () use ($di) {
                $config = $di->getConfig();
                $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
                $params = [
                    'host' => $config->database->host,
                    'username' => $config->database->username,
                    'password' => $config->database->password,
                    'dbname' => $config->database->dbname,
                    'charset' => $config->database->charset,
                    'options' => [
                        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'",
                        PDO::ATTR_CASE               => PDO::CASE_LOWER,
                    ],
                ];

                if ($config->database->adapter == 'Postgresql') {
                    unset($params['charset']);
                }

                return new $class($params);
            }
        );
    }
}