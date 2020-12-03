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
    public function register(DiInterface $di)
    {
        $di->setShared(
            'redis',
            function () use ($di){
                $config = $di->getShared('config');
                $config->redis->host;
            }
        );
    }
}