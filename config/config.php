<?php
declare(strict_types=1);

/*
 * Modified: prepend directory path of current file, because of this file own different ENV under between Apache and command line.
 * NOTE: please remove this comment.
 */
defined('BASE_PATH') || define('BASE_PATH', getenv('BASE_PATH') ?: realpath(dirname(__FILE__) . '/..'));
defined('APP_PATH') || define('APP_PATH', BASE_PATH . '/app');

return [
    'application' => [
        'appDir'            => APP_PATH . '/',
        'controllersDir'    => APP_PATH . '/Controllers/',
        'modelsDir'         => APP_PATH . '/Models/',
        'migrationsDir'     => APP_PATH . '/Migrations/',
        'pluginsDir'        => APP_PATH . '/Plugins/',
        'libraryDir'        => APP_PATH . '/library/',
        'cacheDir'          => BASE_PATH . '/storage/logs/',
        'baseUri'           => '/',
        'migrationsTsBased' => true, // true - Use TIMESTAMP as version name, false - use versions
    ],
];
