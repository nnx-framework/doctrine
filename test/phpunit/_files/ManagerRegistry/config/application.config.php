<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\Doctrine\Module;
use Nnx\ModuleOptions\Module as ModuleOptions;

return [
    'modules'                 => [
        ModuleOptions::MODULE_NAME,
        Module::MODULE_NAME
    ],
    'module_listener_options' => [
        'module_paths'      => [
            Module::MODULE_NAME => TestPaths::getPathToModule(),
        ],
        'config_glob_paths' => [
            __DIR__ . '/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ]
];
