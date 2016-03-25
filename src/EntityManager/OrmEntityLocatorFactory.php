<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;


/**
 * Class OrmEntityLocatorFactory
 *
 * @package Nnx\Doctrine\EntityManager
 */
class OrmEntityLocatorFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return OrmEntityLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $appServiceLocator = $serviceLocator;
        if ($appServiceLocator instanceof AbstractPluginManager) {
            $appServiceLocator->getServiceLocator();
        }

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $appServiceLocator->get(ObjectManagerAutoDetectorInterface::class);

        return new OrmEntityLocator($objectManagerAutoDetector);
    }
}
