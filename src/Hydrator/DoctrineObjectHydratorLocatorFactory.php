<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Hydrator;

use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface;

/**
 * Class DoctrineObjectHydratorLocatorFactory
 *
 * @package Nnx\Doctrine\Hydrator
 */
class DoctrineObjectHydratorLocatorFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DoctrineObjectHydratorLocator
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appServiceLocator = $serviceLocator;
        if ($appServiceLocator instanceof AbstractPluginManager) {
            $appServiceLocator->getServiceLocator();
        }

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $appServiceLocator->get(ObjectManagerAutoDetectorInterface::class);

        /** @var DoctrineObjectManagerInterface $objectManager */
        $objectManager = $appServiceLocator->get(DoctrineObjectManagerInterface::class);


        return new DoctrineObjectHydratorLocator($objectManagerAutoDetector, $objectManager);
    }
}
