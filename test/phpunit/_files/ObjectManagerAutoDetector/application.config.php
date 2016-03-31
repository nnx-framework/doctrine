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
        'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule1',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule2',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule3',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule4',

    ],
    'module_listener_options' => [
        'module_paths'      => [
            'Nnx\\Doctrine' => TestPaths::getPathToModule(),
            'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule1' => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule1',
            'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule2' => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule2',
            'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule3' => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule3',
            'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule4' => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule4',

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
