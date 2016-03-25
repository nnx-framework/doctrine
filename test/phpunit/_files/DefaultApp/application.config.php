<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;

return [
    'modules'                 => [
        'Nnx\\Doctrine'
    ],
    'module_listener_options' => [
        'module_paths'      => [
            'Nnx\\ModuleOptions' => TestPaths::getPathToModule(),
        ],
        'config_glob_paths' => [
            __DIR__ . '/config/autoload/{{,*.}global,{,*.}local}.php',
        ],
    ]
];
