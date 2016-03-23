<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\Options\ModuleOptions;
use Nnx\Doctrine\Options\ModuleOptionsFactory;
use Nnx\ModuleOptions\ModuleOptionsPluginManager;

return [
    ModuleOptionsPluginManager::CONFIG_KEY => [
        'factories' => [
            ModuleOptions::class => ModuleOptionsFactory::class
        ]
    ]
];