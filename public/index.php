<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use App\Application;
use Phalcon\Events\Manager as EventsManager;
use App\Exceptions\BaseException;
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
    require BASE_PATH . '/config/web/services.php';

    /**
     * Handle routes
     */
    require BASE_PATH . '/config/web/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    require BASE_PATH . '/config/web/loader.php';

    /**
     * Handle the request
     */
    $application = new Application($di);
    $eventsManager = new EventsManager();
    $eventsManager->attach('application:beforeSendResponse',$application);
    $application->setEventsManager($eventsManager);

    //$application->handle($_SERVER['REQUEST_URI'])->send();
    echo $application->handle($_SERVER['REQUEST_URI'])->getContent();
} catch (Throwable $exception) {
    $params = [
        'code' => BaseException::HTTP_INTERNAL_SERVER_ERROR,
        'msg' => $exception->getMessage(),
        'data' => (object)[],
    ];

    if ($config->app_debug){
        $params['trace'] = $exception->getTrace();
    }

    header('HTTP/1.1 '.BaseException::HTTP_INTERNAL_SERVER_ERROR.' '.BaseException::$statusTexts[BaseException::HTTP_INTERNAL_SERVER_ERROR]);
    // 确保FastCGI模式下正常
    header('Status:'.BaseException::HTTP_INTERNAL_SERVER_ERROR.' '.BaseException::$statusTexts[BaseException::HTTP_INTERNAL_SERVER_ERROR]);

    $di->getShared('logger')->error($exception->getTraceAsString());

    echo json_encode($params);exit;
}
