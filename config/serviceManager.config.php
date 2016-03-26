<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\ObjectManager\DoctrineObjectManager;
use Nnx\Doctrine\EntityManager\EntityManager;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorFactory;
use Nnx\Doctrine\EntityManager\OrmEntityLocatorInterface;
use Nnx\Doctrine\EntityManager\OrmEntityLocatorFactory;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigInterface;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigFactory;

return [
    'service_manager' => [
        'invokables'         => [
            DoctrineObjectManager::class => DoctrineObjectManager::class,
            EntityManager::class => EntityManager::class
        ],
        'factories'          => [
            ObjectManagerAutoDetectorInterface::class => ObjectManagerAutoDetectorFactory::class,
            OrmEntityLocatorInterface::class          => OrmEntityLocatorFactory::class,
            DoctrineOrmModuleConfigInterface::class   => DoctrineOrmModuleConfigFactory::class
        ],
        'abstract_factories' => [

        ]
    ],
];


