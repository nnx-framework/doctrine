<?php

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\ZF2TestToolkit\Listener\InitTestAppListener;
use Nnx\ZF2TestToolkit\Listener\StopDoctrineLoadCliPostEventListener;
use Nnx\Doctrine\Module;
use Nnx\ModuleOptions\Module as ModuleOptions;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Module as TestModule1;

return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        ModuleOptions::MODULE_NAME,
        Module::MODULE_NAME,
        TestModule1::MODULE_NAME,

    ],
    'module_listener_options' => [
        'module_paths'      => [
            Module::MODULE_NAME => TestPaths::getPathToModule(),
            TestModule1::MODULE_NAME => TestPaths::getPathToDiscriminatorEntryAppModuleDir() . 'TestModule1',

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
