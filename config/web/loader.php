<?php
declare(strict_types=1);

use Phalcon\Loader;

$loader = new Loader();

/**
 * File Extensions
 */
// $loader->setExtensions(['php']);

//$loader->registerNamespaces(
//    [
//        'App' => APP_PATH . '/',
//        'App\\Controllers' => BASE_PATH . '/app/Controllers',
//        'App\\Models' => BASE_PATH . '/app/Models',
//        'App\\Exception' => BASE_PATH . '/app/Exceptions/',
//        'App\\Plugins' => BASE_PATH . '/app/Plugins/',
//    ]
//)->register();

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();
