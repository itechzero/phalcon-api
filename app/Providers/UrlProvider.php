<?php
declare(strict_types=1);

namespace App\Providers;

use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\Url as UrlResolver;

class UrlProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'url',
            function () use ($di) {
                $config = $di->getShared('config');
                $url = new UrlResolver();
                $url->setBaseUri($config->application->baseUri);
                return $url;
            }
        );
    }
}