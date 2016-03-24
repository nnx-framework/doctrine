<?php

use \Nnx\Doctrine\PhpUnit\TestData\TestPaths;


return [
    'modules'                 => [
        'DoctrineModule',
        'DoctrineORMModule',
        'Nnx\\ModuleOptions',
        'Nnx\\Doctrine',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityAutoResolve\\TestModule1',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityAutoResolve\\TestModule2',
        'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityAutoResolve\\TestModule3',

    ],
    'module_listener_options' => [
        'module_paths'      => [
            'Nnx\\Doctrine' => TestPaths::getPathToModule(),
            'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityAutoResolve\\TestModule1' => TestPaths::getPathToEntityAutoResolveAppModuleDir() . 'TestModule1',
            'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityAutoResolve\\TestModule2' => TestPaths::getPathToEntityAutoResolveAppModuleDir() . 'TestModule2',
            'Nnx\\Doctrine\\PhpUnit\\TestData\\EntityAutoResolve\\TestModule3' => TestPaths::getPathToEntityAutoResolveAppModuleDir() . 'TestModule3',

        ],
        'config_glob_paths' => [
            __DIR__ . '/config/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ]
];
