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
use Nnx\Doctrine\Resolver;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigInterface;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigFactory;
use Nnx\Doctrine\Utils\EntityMapBuilderInterface;
use Nnx\Doctrine\Utils\EntityMapBuilderFactory;
use Nnx\Doctrine\Utils\EntityMapCacheInterface;
use Nnx\Doctrine\Utils\EntityMapCacheFactory;
use Nnx\Doctrine\Hydrator\DoctrineObjectHydratorLocatorInterface;
use Nnx\Doctrine\Hydrator\DoctrineObjectHydratorLocatorFactory;
use Nnx\Doctrine\DiscriminatorEntry\DiscriminatorEntryListener;
use Nnx\Doctrine\DiscriminatorEntry\DiscriminatorEntryListenerFactory;
use Nnx\Doctrine\Service\ObjectManagerServiceInterface;
use Nnx\Doctrine\Service\ObjectManagerServiceFactory;
use Nnx\Doctrine\ManagerRegistry\ManagerRegistry;
use Nnx\Doctrine\ManagerRegistry\ManagerRegistryFactory;
use Nnx\Doctrine\ManagerRegistry\ParamsFromDoctrineModuleListener;
use Nnx\Doctrine\ManagerRegistry\ParamsFromDoctrineModuleListenerFactory;
use Nnx\Doctrine\ManagerRegistry\ResolverManagerRegistryResourceListener;
use Nnx\Doctrine\ManagerRegistry\ResolverManagerRegistryResourceListenerFactory;
use Nnx\Doctrine\Listener\ManagerRegistryListener;
use \Nnx\Doctrine\Listener\ManagerRegistryListenerFactory;

return [
    'service_manager' => [
        'invokables'         => [
            DoctrineObjectManagerInterface::class => DoctrineObjectManager::class,
            EntityManagerInterface::class         => EntityManager::class
        ],
        'factories'          => [
            ObjectManagerAutoDetectorInterface::class      => ObjectManagerAutoDetectorFactory::class,
            OrmEntityLocatorInterface::class               => OrmEntityLocatorFactory::class,
            DoctrineOrmModuleConfigInterface::class        => DoctrineOrmModuleConfigFactory::class,
            EntityMapBuilderInterface::class               => EntityMapBuilderFactory::class,
            EntityMapCacheInterface::class                 => EntityMapCacheFactory::class,
            DoctrineObjectHydratorLocatorInterface::class  => DoctrineObjectHydratorLocatorFactory::class,
            DiscriminatorEntryListener::class              => DiscriminatorEntryListenerFactory::class,
            ObjectManagerServiceInterface::class           => ObjectManagerServiceFactory::class,
            ManagerRegistry::class                         => ManagerRegistryFactory::class,
            ParamsFromDoctrineModuleListener::class        => ParamsFromDoctrineModuleListenerFactory::class,
            ResolverManagerRegistryResourceListener::class => ResolverManagerRegistryResourceListenerFactory::class,
            ManagerRegistryListener::class                 => ManagerRegistryListenerFactory::class,
            Resolver\EntityListenerResolver::class         => Resolver\EntityListenerResolverFactory::class,
        ],
        'abstract_factories' => [

        ],
        'aliases'            => [
            DoctrineObjectManager::class => DoctrineObjectManagerInterface::class,
            EntityManager::class         => EntityManagerInterface::class
        ]
    ],
];


