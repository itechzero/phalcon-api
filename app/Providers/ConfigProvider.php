<?php
declare(strict_types=1);

namespace App\Providers;

use Phalcon\Config;
use Phalcon\Di\DiInterface;
use Phalcon\Di\ServiceProviderInterface;

class ConfigProvider implements ServiceProviderInterface
{
    /**
     * @param DiInterface $di
     */
    public function register(DiInterface $di): void
    {
        $di->setShared(
            'config',
            function () {
                $baseConfig = new Config(require BASE_PATH . '/config/config.php');
                $constConfig = new Config(require BASE_PATH . '/config/app.php');
                return $baseConfig->merge($constConfig);
            }
        );
    }
}