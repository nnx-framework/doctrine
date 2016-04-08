<?php

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\ZF2TestToolkit\Listener\InitTestAppListener;
use Nnx\ZF2TestToolkit\Listener\StopDoctrineLoadCliPostEventListener;
use Nnx\ModuleOptions\Module as ModuleOptions;
use Nnx\Doctrine\Module;
use Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector as TestApp;

return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        ModuleOptions::MODULE_NAME,
        Module::MODULE_NAME,
        TestApp\TestModule1\Module::MODULE_NAME,
        TestApp\TestModule2\Module::MODULE_NAME,
        TestApp\TestModule3\Module::MODULE_NAME,
        TestApp\TestModule4\Module::MODULE_NAME,
    ],
    'module_listener_options' => [
        'module_paths'      => [
            Module::MODULE_NAME => TestPaths::getPathToModule(),
            TestApp\TestModule1\Module::MODULE_NAME => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule1',
            TestApp\TestModule2\Module::MODULE_NAME => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule2',
            TestApp\TestModule3\Module::MODULE_NAME => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule3',
            TestApp\TestModule4\Module::MODULE_NAME => TestPaths::getPathToObjectManagerAutoDetectorAppModuleDir() . 'TestModule4',

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
