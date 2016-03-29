<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\DiscriminatorEntry;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Nnx\Doctrine\Options\ModuleOptionsInterface;
use Doctrine\Common\Annotations\CachedReader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\Cache;

/**
 * Class DiscriminatorEntryListenerFactory
 *
 * @package Nnx\Doctrine\DiscriminatorEntry
 */
class DiscriminatorEntryListenerFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DiscriminatorEntryListener
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Nnx\Doctrine\DiscriminatorEntry\Exception\AnnotationReaderException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsPluginManager */
        $moduleOptionsPluginManager = $serviceLocator->get(ModuleOptionsPluginManagerInterface::class);

        /** @var ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $moduleOptionsPluginManager->get(ModuleOptionsInterface::class);

        $metadataReaderCacheServiceName = $moduleOptions->getMetadataReaderCache();

        /** @var Cache $metadataReaderCache */
        $metadataReaderCache = $serviceLocator->get($metadataReaderCacheServiceName);

        $reader = new AnnotationReader();
        $reader = new CachedReader($reader, $metadataReaderCache);

        return new DiscriminatorEntryListener($reader);
    }
}
