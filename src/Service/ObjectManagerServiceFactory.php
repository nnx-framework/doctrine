<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Service;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\EntityManager\EntityManagerInterface;

/**
 * Class ObjectManagerServiceFactory
 *
 * @package Nnx\Doctrine\Service
 */
class ObjectManagerServiceFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return ObjectManagerService
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $serviceLocator->get(ObjectManagerAutoDetectorInterface::class);

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $serviceLocator->get(EntityManagerInterface::class);

        return new ObjectManagerService($objectManagerAutoDetector, $entityManager);
    }
}
