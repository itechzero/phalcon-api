<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault\Cli as CliDi;
use Phalcon\Cli\Console as ConsoleApp;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

/**
 * Composer autoload.
 */
require_once BASE_PATH . '/vendor/autoload.php';

/**
 * The FactoryDefault Dependency Injector automatically registers the services that
 * provide a full stack framework. These default services can be overidden with custom ones.
 */
$di = new CliDi();

/**
 * Include Services
 */
require BASE_PATH . '/config/cli/services.php';

/**
 * Get config service for use in inline setup below
 */
$config = $di->getConfig();

/**
 * Include Autoloader
 */
require BASE_PATH . '/config/cli/loader.php';

/**
 * Create a console application
 */
$console = new ConsoleApp($di);
$di->setShared('console', $console);

/**
 * Process the console arguments
 */
$arguments = [];

foreach ($argv as $k => $arg) {
    if ($k === 1) {
        $arguments['task'] = $arg;
    } elseif ($k === 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

try {

    /**
     * Handle
     */
    $console->handle($arguments);

    if (isset($config['printNewLine']) && $config['printNewLine']) {
        echo PHP_EOL;
    }

} catch (Exception $e) {
    echo $e->getCode() . PHP_EOL;
    echo $e->getFile() . PHP_EOL;
    echo $e->getLine() . PHP_EOL;
    echo $e->getMessage() . PHP_EOL;
    echo $e->getTraceAsString() . PHP_EOL;
    exit(1);
} catch (Throwable $throwable) {
    echo $throwable->getCode() . PHP_EOL;
    echo $throwable->getFile() . PHP_EOL;
    echo $throwable->getLine() . PHP_EOL;
    echo $throwable->getMessage() . PHP_EOL;
    echo $throwable->getTraceAsString() . PHP_EOL;
    exit(1);
}