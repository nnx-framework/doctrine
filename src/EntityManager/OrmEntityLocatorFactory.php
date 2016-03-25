<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Nnx\Doctrine\Options\ModuleOptionsInterface;

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

        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsManager */
        $moduleOptionsManager = $appServiceLocator->get(ModuleOptionsPluginManagerInterface::class);
        /** @var ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $moduleOptionsManager->get(ModuleOptionsInterface::class);

        return new OrmEntityLocator($objectManagerAutoDetector, $moduleOptions);
    }
}
