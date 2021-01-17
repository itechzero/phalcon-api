<?php
declare(strict_types=1);

/**
 * Shared configuration service
 */
$di->register(new \App\Providers\ConfigProvider());

/**
 * Support Log
 */
$di->register(new \App\Providers\LogProvider());

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->register(new \App\Providers\DbProvider());

/**
 * DispatcherCliProvider
 */
$di->register(new \App\Providers\DispatcherCliProvider());

/**
 * Support RabbitMQ
 */
$di->register(new \App\Providers\RabbitMQProvider());