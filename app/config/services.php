<?php
declare(strict_types=1);

use Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter;

/**
 * Shared configuration service
 */
$di->register(new \App\Providers\ConfigProvider());

/**
 * The URL component is used to generate all kind of urls in the application
 */
//$di->register(new \App\Providers\UrlProvider());

/**
 * Setting up the view component
 */
$di->register(new \App\Providers\ViewProvider());

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->register(new \App\Providers\DbProvider());
//$di->setShared('db', function () {
//    $config = $this->getConfig();
//
//    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
//    $params = [
//        'host'     => $config->database->host,
//        'username' => $config->database->username,
//        'password' => $config->database->password,
//        'dbname'   => $config->database->dbname,
//        'charset'  => $config->database->charset
//    ];
//
//    if ($config->database->adapter == 'Postgresql') {
//        unset($params['charset']);
//    }
//
//    return new $class($params);
//});


/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
$di->setShared('modelsMetadata', function () {
    return new MetaDataAdapter();
});


/**
 * Register the session flash service with the Twitter Bootstrap classes
 */
//$di->set('flash', function () {
//    $escaper = new Escaper();
//    $flash = new Flash($escaper);
//    $flash->setImplicitFlush(false);
//    $flash->setCssClasses([
//        'error'   => 'alert alert-danger',
//        'success' => 'alert alert-success',
//        'notice'  => 'alert alert-info',
//        'warning' => 'alert alert-warning'
//    ]);
//
//    return $flash;
//});

/**
 * Start the session the first time some component request the session service
 */
//$di->setShared('session', function () {
//    $session = new SessionManager();
//    $files = new SessionAdapter([
//        'savePath' => sys_get_temp_dir(),
//    ]);
//    $session->setAdapter($files);
//    $session->start();
//
//    return $session;
//});

//$di->setShared(
//    'session',
//    function () {
//        $session = new \Phalcon\Session\Adapter\Redis([
//            'uniqueId'   => 'xxxxx',
//            'prefix'     => '',
//            'lifetime'   => 86400,
//            'host'       => 'xxx.xx.xx.xxx',
//            'port'       => 6379,
//            'auth'       => 'xxxxxxxxx',
//            'persistent' => false,
//        ]);
//        $config = $this->getConfig();
//
//        $class = 'Phalcon\Session\Adapter\Redis';
//        $params = [
//            'host'     => $config->database->host,
//            'username' => $config->database->username,
//            'password' => $config->database->password,
//            'dbname'   => $config->database->dbname,
//            'charset'  => $config->database->charset
//        ];
//
//
//        return (new $class($params))->start();
//    }
//);