<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

use Doctrine\Common\Cache\VoidCache;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Nnx\Doctrine\Options\ModuleOptionsInterface;
use Doctrine\Common\Cache\Cache;

/**
 * Class EntityMapCacheFactory
 *
 * @package Nnx\Doctrine\Utils
 */
class EntityMapCacheFactory implements FactoryInterface
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
        /** @var EntityMapBuilderInterface $entityMapBuilder */
        $entityMapBuilder = $serviceLocator->get(EntityMapBuilderInterface::class);

        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsManager */
        $moduleOptionsManager = $serviceLocator->get(ModuleOptionsPluginManagerInterface::class);
        /** @var ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $moduleOptionsManager->get(ModuleOptionsInterface::class);
        $cacheServiceName = $moduleOptions->getEntityMapDoctrineCache();

        if (null === $cacheServiceName) {
            $cache = new VoidCache();
        } else {
            /** @var Cache $cache */
            $cache = $serviceLocator->get($cacheServiceName);
        }


        return new EntityMapCache($entityMapBuilder, $cache, $moduleOptions);
    }
}
