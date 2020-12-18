<?php
declare(strict_types=1);

$loader = new \Phalcon\Loader();

$loader->registerDirs([
    APP_PATH . '/Tasks',
    APP_PATH . '/Models',
]);

$loader->register();
