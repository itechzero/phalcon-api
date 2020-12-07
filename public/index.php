<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use App\Application;
use Phalcon\Events\Manager as EventsManager;
use App\Exceptions\BaseException;
use Phalcon\Logger;
use Phalcon\Logger\Adapter\Stream;
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

//    set_error_handler(
//        function ($errorNo, $errorStr, $errorFile, $errorLine)
//        {
//            throw new BaseException($errorStr);
//        }
//    );

    //$application->handle($_SERVER['REQUEST_URI'])->send();
    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (Exception $exception) {
    //dd($exception->getMessage());
    $adapter = new Stream(sprintf(BASE_PATH.'/storage/logs/runtime-%s.log',date('Y-m-d')));
    $logger  = new Logger(
        'messages',
        [
            'main' => $adapter,
        ]
    );

    $logger->debug($exception->getMessage());
    $logger->error($exception->getTraceAsString());
    $params = [
        'code' => BaseException::HTTP_INTERNAL_SERVER_ERROR,
        'msg' => BaseException::$statusTexts[BaseException::HTTP_INTERNAL_SERVER_ERROR],
        'data' => (object)[],
    ];
    $params['msg'] = $exception->getMessage();
    $params['trace'] = $exception->getTrace();
    var_dump($params);
//    echo $e->getMessage() . '<br>';
//    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
