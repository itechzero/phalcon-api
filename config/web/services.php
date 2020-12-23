<?php
declare(strict_types=1);

/**
 * Shared configuration service
 */
$di->register(new \App\Providers\ConfigProvider());

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->register(new \App\Providers\UrlProvider());

/**
 * Setting up the view component
 */
$di->register(new \App\Providers\ViewProvider());

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->register(new \App\Providers\DbProvider());

/**
 * DispatcherProvider
 */
$di->register(new \App\Providers\DispatcherProvider());

/**
 * Support Redis
 */
$di->register(new \App\Providers\RedisProvider());

/**
 * Support Log
 */
$di->register(new \App\Providers\LogProvider());

/**
 * Support RabbitMQ
 */
$di->register(new \App\Providers\RabbitMQProvider());

/**
 * If the configuration specify the use of metadata adapter use it or use memory otherwise
 */
// $di->register(new \App\Providers\ModelsMetadataProvider());


/**
 * Start the session the first time some component request the session service
 */
// $di->register(new \App\Providers\SessionProvider());

