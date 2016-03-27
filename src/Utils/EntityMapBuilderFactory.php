<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Nnx\Doctrine\EntityManager\EntityManagerInterface;


/**
 * Class EntityMapBuilderFactory
 *
 * @package Nnx\Doctrine\Utils
 */
class EntityMapBuilderFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return EntityMapBuilder
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var DoctrineObjectManagerInterface $doctrineObjectManager */
        $doctrineObjectManager = $serviceLocator->get(DoctrineObjectManagerInterface::class);

        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsPluginManager */
        $moduleOptionsPluginManager = $serviceLocator->get(ModuleOptionsPluginManagerInterface::class);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get(EntityManagerInterface::class);

        return new EntityMapBuilder($doctrineObjectManager, $moduleOptionsPluginManager, $entityManager);
    }
}
