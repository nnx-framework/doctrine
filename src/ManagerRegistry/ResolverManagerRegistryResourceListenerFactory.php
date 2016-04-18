<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface;

/**
 * Class ResolverManagerRegistryResourceListenerFactory
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ResolverManagerRegistryResourceListenerFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var DoctrineObjectManagerInterface $objectManagerLocator */
        $objectManagerLocator = $serviceLocator->get(DoctrineObjectManagerInterface::class);

        return new ResolverManagerRegistryResourceListener($objectManagerLocator, $serviceLocator);
    }
}
