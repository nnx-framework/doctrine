<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use \Nnx\Doctrine\ManagerRegistry\ManagerRegistry;

/**
 * Class ManagerRegistryListenerFactory
 *
 * @package Nnx\Doctrine\Listener
 */
class ManagerRegistryListenerFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ManagerRegistryListener
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $serviceLocator->get(ManagerRegistry::class);

        return new ManagerRegistryListener($managerRegistry);
    }
}
