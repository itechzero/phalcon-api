<?php
declare(strict_types=1);

/**
 * Shared configuration service
 */
$di->register(new \App\Providers\ConfigProvider());

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->register(new \App\Providers\DbProvider());

