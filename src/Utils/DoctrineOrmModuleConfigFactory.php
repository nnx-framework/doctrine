<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

use Nnx\Doctrine\Options\ModuleOptionsInterface;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class DoctrineOrmModuleConfigFactory
 *
 * @package Nnx\Doctrine\Utils
 */
class DoctrineOrmModuleConfigFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return DoctrineOrmModuleConfig
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        /** @var array  $appConfig */
        $appConfig = $serviceLocator->get('config');
        $doctrineConfig = array_key_exists('doctrine', $appConfig) ? $appConfig['doctrine'] : [];

        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsManager */
        $moduleOptionsManager = $serviceLocator->get(ModuleOptionsPluginManagerInterface::class);
        /** @var ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $moduleOptionsManager->get(ModuleOptionsInterface::class);

        return new DoctrineOrmModuleConfig($doctrineConfig, $moduleOptions);
    }
}
