<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */

use Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule2\Options\ModuleOptions;
use Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule2\Options\ModuleOptionsFactory;


return [
    'test_module_2' => [
        'objectManagerName' => 'doctrine.entitymanager.test'
    ],
    'module_options' => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class
        ]
    ],
    'doctrine' => [
        'driver' => [
            'testModule2' => [
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            ],
        ]
    ]
];