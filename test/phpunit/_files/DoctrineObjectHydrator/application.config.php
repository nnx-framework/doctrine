<?php

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\ZF2TestToolkit\Listener\InitTestAppListener;
use Nnx\ZF2TestToolkit\Listener\StopDoctrineLoadCliPostEventListener;

return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        'Nnx\\ModuleOptions',
        'Nnx\\Doctrine',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\DoctrineObjectHydrator\\TestModule1'

    ],
    'module_listener_options' => [
        'module_paths'      => [
            'Nnx\\Doctrine' => TestPaths::getPathToModule(),
            'Nnx\\Doctrine\\PhpUnit\\TestData\\DoctrineObjectHydrator\\TestModule1' => TestPaths::getPathToDoctrineObjectHydratorAppModuleDir() . 'TestModule1',

        ],
        'config_glob_paths' => [
            __DIR__ . '/config/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ],
    'service_manager'         => [
        'invokables' => [
            InitTestAppListener::class => InitTestAppListener::class,
            StopDoctrineLoadCliPostEventListener::class => StopDoctrineLoadCliPostEventListener::class
        ]
    ],
    'listeners'               => [
        InitTestAppListener::class,
        StopDoctrineLoadCliPostEventListener::class
    ]
];
