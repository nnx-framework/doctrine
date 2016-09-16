<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\Doctrine\Module;
use Nnx\ModuleOptions\Module as ModuleOptions;
use Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Module as TestModule1;
use Nnx\ZF2TestToolkit\Listener\InitTestAppListener;

return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        ModuleOptions::MODULE_NAME,
        Module::MODULE_NAME,
        TestModule1::MODULE_NAME
    ],
    'module_listener_options' => [
        'module_paths'      => [
            Module::MODULE_NAME      => TestPaths::getPathToModule(),
            TestModule1::MODULE_NAME => __DIR__ . '/../module/TestModule1'
        ],
        'config_glob_paths' => [
            __DIR__ . '/autoload/{{,*.}global,{,*.}local}.php',
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
