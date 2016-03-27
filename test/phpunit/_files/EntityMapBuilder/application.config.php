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
        'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule1',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule2',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule3',

    ],
    'module_listener_options' => [
        'module_paths'      => [
            'Nnx\\Doctrine' => TestPaths::getPathToModule(),
            'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule1' => TestPaths::getPathToEntityMapBuilderAppModuleDir() . 'TestModule1',
            'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule2' => TestPaths::getPathToEntityMapBuilderAppModuleDir() . 'TestModule2',
            'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityMapBuilder\\TestModule3' => TestPaths::getPathToEntityMapBuilderAppModuleDir() . 'TestModule3',

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
