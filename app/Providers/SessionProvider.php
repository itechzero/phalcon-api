<?php
declare(strict_types=1);

namespace App\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Session\Adapter\Redis;
use Phalcon\Session\Adapter\Stream as SessionAdapter;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Storage\AdapterFactory;
use Phalcon\Storage\SerializerFactory;

class SessionProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        $config = $di->getConfig();
        $options = [
            'host' => $config->redis->host,
            'port' => $config->redis->port,
            'index' => $config->redis->index,
        ];
        $di->setShared(
            'session',
            function () use ($options) {
                $session = new SessionManager();
                $serializerFactory = new SerializerFactory();
                $factory = new AdapterFactory($serializerFactory);
                $redis = new Redis($factory, $options);

                $session
                    ->setAdapter($redis)
                    ->start();
                return $session;
            }
        );
    }
}