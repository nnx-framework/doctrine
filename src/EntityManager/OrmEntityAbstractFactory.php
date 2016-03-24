<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface;

/**
 * Class OrmAbstractFactory
 *
 * @package Nnx\Doctrine\EntityManager
 */
class OrmEntityAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Кеш сущностей
     *
     * @var array
     */
    protected $entityCache = [];



    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return bool
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (array_key_exists($requestedName, $this->entityCache)) {
            return !(false === $this->entityCache[$requestedName]);
        }

        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsManager */
        $moduleOptionsManager = $appServiceLocator->get(ModuleOptionsPluginManagerInterface::class);
        $moduleOptions = $moduleOptionsManager->getOptionsByClassName($requestedName);

        if (!$moduleOptions instanceof ObjectManagerNameProviderInterface) {
            $this->entityCache[$requestedName] = false;
            return false;
        }

        $objectManagerName = $moduleOptions->getObjectManagerName();

        if (0 !== strpos($objectManagerName, 'doctrine.entitymanager.')) {
            $this->entityCache[$requestedName] = false;
            return false;
        }

        $doctrineEntityManager = substr($objectManagerName, 23);

        /** @var array $appConfig */
        $appConfig = $appServiceLocator->get('config');

        $flagExistsConfig = array_key_exists('doctrine', $appConfig)
                            && array_key_exists('entitymanager', $appConfig['doctrine'])
                            && array_key_exists($doctrineEntityManager, $appConfig['doctrine']['entitymanager']);


        if (!$flagExistsConfig) {
            $this->entityCache[$requestedName] = false;
            return false;
        }

        $emConfig = $appConfig['doctrine']['entitymanager'][$doctrineEntityManager];



        return false;
    }

    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return mixed
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        return false;
    }
}
