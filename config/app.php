<?php
declare(strict_types=1);

return [
    'app_env' => 'local',
    'app_debug' => true,

    'logger' => [
        'name'     => 'prod-logger',
        'adapters' => [
            'runtime'  => [
                'adapter' => 'stream',
                'name'    => sprintf('runtime-%s.log', date('Y-m-d')),
                'options' => []
            ],
            'task' => [
                'adapter' => 'stream',
                'name'    => sprintf('task-%s.log', date('Y-m-d')),
                'options' => []
            ],
        ],
    ],
];