<?php
declare(strict_types=1);

use Phalcon\Loader;

$loader = new Loader();

$loader->registerNamespaces(
    [
        'App' => APP_PATH . '/',
        'Tasks' => APP_PATH . '/Tasks',
    ]
)->register();

$loader->registerDirs(
    [
        APP_PATH . '/Tasks',
        APP_PATH . '/Models',
    ]
);

$loader->register();
