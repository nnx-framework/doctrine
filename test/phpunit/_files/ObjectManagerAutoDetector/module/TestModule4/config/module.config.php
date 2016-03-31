<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */

use Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector\TestModule4\Options\ModuleOptions;
use Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector\TestModule4\Options\ModuleOptionsFactory;

return [
    'test_module_4' => [
        'objectManagerName' => 'invalidValue'
    ],
    'module_options' => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class
        ]
    ]
];