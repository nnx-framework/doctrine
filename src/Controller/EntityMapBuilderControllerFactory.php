<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Controller;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManager;
use Nnx\Doctrine\Utils\EntityMapBuilderInterface;


/**
 * Class EntityMapBuilderController
 *
 * @package Nnx\Doctrine\Controller
 */
class EntityMapBuilderControllerFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return EntityMapBuilderController
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var DoctrineObjectManager $doctrineObjectManager */
        $doctrineObjectManager = $appServiceLocator->get(DoctrineObjectManager::class);

        /** @var EntityMapBuilderInterface $entityMapBuilder */
        $entityMapBuilder = $appServiceLocator->get(EntityMapBuilderInterface::class);

        return new EntityMapBuilderController($doctrineObjectManager, $entityMapBuilder);
    }
}
