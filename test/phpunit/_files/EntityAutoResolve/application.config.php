<?php

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\ZF2TestToolkit\Listener\InitTestAppListener;
use Nnx\ZF2TestToolkit\Listener\StopDoctrineLoadCliPostEventListener;
use Nnx\Doctrine\Module;
use Nnx\ModuleOptions\Module as ModuleOptions;
use Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve;

return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        ModuleOptions::MODULE_NAME,
        Module::MODULE_NAME,
        EntityAutoResolve\TestModule1\Module::MODULE_NAME,
        EntityAutoResolve\TestModule2\Module::MODULE_NAME,
        EntityAutoResolve\TestModule3\Module::MODULE_NAME,

    ],
    'module_listener_options' => [
        'module_paths'      => [
            Module::MODULE_NAME => TestPaths::getPathToModule(),
            EntityAutoResolve\TestModule1\Module::MODULE_NAME => TestPaths::getPathToEntityAutoResolveAppModuleDir() . 'TestModule1',
            EntityAutoResolve\TestModule2\Module::MODULE_NAME => TestPaths::getPathToEntityAutoResolveAppModuleDir() . 'TestModule2',
            EntityAutoResolve\TestModule3\Module::MODULE_NAME => TestPaths::getPathToEntityAutoResolveAppModuleDir() . 'TestModule3',

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
