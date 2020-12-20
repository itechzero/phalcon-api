<?php
declare(strict_types=1);

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'App' => APP_PATH . '/',
        'App\\Tasks' => APP_PATH . '/Tasks/',
    ]
)->register();

$loader->registerDirs([
    APP_PATH . '/Tasks',
    APP_PATH . '/Models',
]);

$loader->register();
