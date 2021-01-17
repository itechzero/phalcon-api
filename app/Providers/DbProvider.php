<?php
declare(strict_types=1);

namespace App\Providers;

use PDO;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Events\Manager;

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
                $eventsManager = new Manager();
                $logger = $di->getShared('log');
                $profiler = $di->getProfiler();

                $eventsManager->attach(
                    'db',
                    function ($event, $connection) use ($logger, $profiler) {
                        if ($event->getType() === 'beforeQuery') {
                            $profiler->startProfile(
                                $connection->getSQLStatement()
                            );
                        }

                        if ($event->getType() === 'afterQuery') {
                            $profiler->stopProfile();
                            $logger->info(
                                $connection->getSQLStatement()
                            );
                        }
                    }
                );

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
                        PDO::ATTR_CASE => PDO::CASE_LOWER,
                        PDO::ATTR_EMULATE_PREPARES => false,
                        PDO::ATTR_STRINGIFY_FETCHES => false,
                    ],
                ];

                if (PHP_SAPI == 'cli') {
                    $params['options'][PDO::ATTR_PERSISTENT] = true;
                }

                if ($config->database->adapter == 'Postgresql') {
                    unset($params['charset']);
                }

                $connection = new $class($params);

                $connection->setEventsManager($eventsManager);

                return $connection;

            }
        );
    }
}