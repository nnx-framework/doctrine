<?php

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\ZF2TestToolkit\Listener\InitTestAppListener;
use Nnx\ZF2TestToolkit\Listener\StopDoctrineLoadCliPostEventListener;
use Nnx\ModuleOptions\Module as ModuleOptions;
use Nnx\Doctrine\Module;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder;


return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        ModuleOptions::MODULE_NAME,
        Module::MODULE_NAME,
        EntityMapBuilder\TestModule1\Module::MODULE_NAME,
        EntityMapBuilder\TestModule2\Module::MODULE_NAME,
        EntityMapBuilder\TestModule3\Module::MODULE_NAME,

    ],
    'module_listener_options' => [
        'module_paths'      => [
            Module::MODULE_NAME => TestPaths::getPathToModule(),
            EntityMapBuilder\TestModule1\Module::MODULE_NAME => TestPaths::getPathToEntityMapBuilderAppModuleDir() . 'TestModule1',
            EntityMapBuilder\TestModule2\Module::MODULE_NAME => TestPaths::getPathToEntityMapBuilderAppModuleDir() . 'TestModule2',
            EntityMapBuilder\TestModule3\Module::MODULE_NAME => TestPaths::getPathToEntityMapBuilderAppModuleDir() . 'TestModule3',

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
