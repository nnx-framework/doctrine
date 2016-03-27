<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */

use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule3\Options\ModuleOptions;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule3\Options\ModuleOptionsFactory;


return [
    'test_module_3' => [
        'objectManagerName' => 'doctrine.entitymanager.test'
    ],
    'module_options' => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class
        ]
    ],
    'doctrine' => [
        'driver' => [
            'testModule3' => [
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            ],
        ]
    ]
];