<?php
declare(strict_types=1);

namespace App\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Redis;

/**
 * Class RedisProvider
 * @package App\Providers
 */
class RedisProvider implements ServiceProviderInterface
{
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'redis',
            function () use ($di) {
                $config = $di->getShared('config');
                $redis = new Redis();
                $redis->connect($config->redis->host, $config->redis->port, $config->redis->timeout);

                if (!empty($config->redis->auth)) {
                    $redis->auth($config->redis->auth);
                }

                if (!empty($config->redis->index)) {
                    $redis->select($config->redis->index);
                }

                return $redis;
            }
        );
    }
}