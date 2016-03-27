<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\ObjectManager\DoctrineObjectManager;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface;
use Nnx\Doctrine\EntityManager\EntityManager;
use Nnx\Doctrine\EntityManager\EntityManagerInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorFactory;
use Nnx\Doctrine\EntityManager\OrmEntityLocatorInterface;
use Nnx\Doctrine\EntityManager\OrmEntityLocatorFactory;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigInterface;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigFactory;
use Nnx\Doctrine\Utils\EntityMapBuilderInterface;
use Nnx\Doctrine\Utils\EntityMapBuilderFactory;
use Nnx\Doctrine\Utils\EntityMapCacheInterface;
use Nnx\Doctrine\Utils\EntityMapCacheFactory;

return [
    'service_manager' => [
        'invokables'         => [
            DoctrineObjectManagerInterface::class => DoctrineObjectManager::class,
            EntityManagerInterface::class => EntityManager::class
        ],
        'factories'          => [
            ObjectManagerAutoDetectorInterface::class => ObjectManagerAutoDetectorFactory::class,
            OrmEntityLocatorInterface::class          => OrmEntityLocatorFactory::class,
            DoctrineOrmModuleConfigInterface::class   => DoctrineOrmModuleConfigFactory::class,
            EntityMapBuilderInterface::class => EntityMapBuilderFactory::class,
            EntityMapCacheInterface::class => EntityMapCacheFactory::class
        ],
        'abstract_factories' => [

        ],
        'aliases' => [
            DoctrineObjectManager::class => DoctrineObjectManagerInterface::class,
            EntityManager::class => EntityManagerInterface::class
        ]
    ],
];


