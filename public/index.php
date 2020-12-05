<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use App\Application;
use Phalcon\Events\Manager as EventsManager;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {

    /**
     * Composer autoload.
     */
    require_once BASE_PATH . '/vendor/autoload.php';

    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    /**
     * Read services
     */
    require APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    require APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    require APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new Application($di);
    $eventsManager = new EventsManager();
    $eventsManager->attach('application:beforeSendResponse',$application);
    $application->setEventsManager($eventsManager);

    //$application->handle($_SERVER['REQUEST_URI'])->send();
    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
