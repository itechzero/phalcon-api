<?php
declare(strict_types=1);

namespace App\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
use Phalcon\Logger\Formatter\Line;

class LoggerProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'logger',
            function () use ($di) {
                $logFile = sprintf('runtime-%s.log', date('Y-m-d'));
                if (PHP_SAPI == 'cli') {
                    $logFile = sprintf('task-%s.log', date('Y-m-d'));
                }
                $traceId = $di->getShared('request')->getServer('X-Request-Id');
                $formatter = new Line('[%date%] - [%type%] [' . $traceId . '] - %message%', 'Y-m-d H:i:s');
                $adapter = new Stream(sprintf(BASE_PATH . '/storage/logs/%s', $logFile));
                $adapter->setFormatter($formatter);
                return new Logger(
                    'messages',
                    [
                        'main' => $adapter,
                    ]
                );
            }
        );
    }
}