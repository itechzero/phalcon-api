<?php
declare(strict_types=1);

$loader = new \Phalcon\Loader();

/**
 * File Extensions
 */
// $loader->setExtensions(['php']);

/**
 * We're a registering a set of directories taken from the configuration file
 */
$loader->registerDirs(
    [
        $config->application->controllersDir,
        $config->application->modelsDir
    ]
)->register();