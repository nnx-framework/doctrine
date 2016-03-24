<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\ZF2TestToolkit\Listener\InitTestAppListener;

return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        'Nnx\\Doctrine'
    ],
    'module_listener_options' => [
        'module_paths'      => [
            'Nnx\\ModuleOptions' => TestPaths::getPathToModule(),
        ],
        'config_glob_paths' => [
            __DIR__ . '/config/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ],
    'service_manager'         => [
        'invokables' => [
            InitTestAppListener::class => InitTestAppListener::class
        ]
    ],
    'listeners'               => [
        InitTestAppListener::class
    ]
];
