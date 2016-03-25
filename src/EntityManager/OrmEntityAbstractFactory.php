<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;


//use Zend\ServiceManager\AbstractPluginManager;
//use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
//use Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface;


/**
 * Class OrmAbstractFactory
 *
 * @package Nnx\Doctrine\EntityManager
 */
class OrmEntityAbstractFactory implements AbstractFactoryInterface
{
    //    /**
//     * Кеш сущностей
//     *
//     * @var array
//     */
//    protected $entityCache = [];
//
//
//
//    /**
//     * @inheritdoc
//     *
//     * @param ServiceLocatorInterface $serviceLocator
//     * @param                         $name
//     * @param                         $requestedName
//     *
//     * @return bool
//     *
//     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
//     */
//    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
//    {
//        if (array_key_exists($requestedName, $this->entityCache)) {
//            return !(false === $this->entityCache[$requestedName]);
//        }
//
//        $appServiceLocator = $serviceLocator;
//        if ($serviceLocator instanceof AbstractPluginManager) {
//            $appServiceLocator = $serviceLocator->getServiceLocator();
//        }
//
//        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsManager */
//        $moduleOptionsManager = $appServiceLocator->get(ModuleOptionsPluginManagerInterface::class);
//        $moduleOptions = $moduleOptionsManager->getOptionsByClassName($requestedName);
//
//        if (!$moduleOptions instanceof ObjectManagerNameProviderInterface) {
//            $this->entityCache[$requestedName] = false;
//            return false;
//        }
//
//        $objectManagerName = $moduleOptions->getObjectManagerName();
//
//        if (0 !== strpos($objectManagerName, 'doctrine.entitymanager.')) {
//            $this->entityCache[$requestedName] = false;
//            return false;
//        }
//
//        $doctrineEntityManager = substr($objectManagerName, 23);
//
//        /** @var array $appConfig */
//        $appConfig = $appServiceLocator->get('config');
//
//        $flagExistsEntityManagerConfig = array_key_exists('doctrine', $appConfig)
//                            && array_key_exists('entitymanager', $appConfig['doctrine'])
//                            && array_key_exists($doctrineEntityManager, $appConfig['doctrine']['entitymanager']);
//
//
//        if (!$flagExistsEntityManagerConfig) {
//            $this->entityCache[$requestedName] = false;
//            return false;
//        }
//
//        $emConfig = $appConfig['doctrine']['entitymanager'][$doctrineEntityManager];
//
//        if (!is_array($emConfig) || !array_key_exists('configuration', $emConfig) || !is_string($emConfig['configuration'])) {
//            $this->entityCache[$requestedName] = false;
//            return false;
//        }
//        $configurationName = $emConfig['configuration'];
//
//        $flagExistsEntityManagerConfiguration = array_key_exists('configuration', $appConfig['doctrine'])
//                                                && array_key_exists($configurationName, $appConfig['doctrine']['configuration']);
//
//
//        if (!$flagExistsEntityManagerConfiguration) {
//            $this->entityCache[$requestedName] = false;
//            return false;
//        }
//
//        $entityManagerConfiguration = $appConfig['doctrine']['configuration'][$configurationName];
//
//        if (!array_key_exists('driver', $entityManagerConfiguration) || !is_string($entityManagerConfiguration['driver'])) {
//            $this->entityCache[$requestedName] = false;
//            return false;
//        }
//
//        $driverName = $entityManagerConfiguration['driver'];
//
//        $flagExistsDriverLists = array_key_exists('driver', $appConfig['doctrine'])
//            && array_key_exists($driverName, $appConfig['doctrine']['driver'])
//            && is_array($appConfig['doctrine']['driver'][$driverName])
//            && array_key_exists('drivers', $appConfig['doctrine']['driver'][$driverName])
//            && is_array($appConfig['doctrine']['driver'][$driverName]['drivers']);
//
//        if (!$flagExistsDriverLists) {
//            $this->entityCache[$requestedName] = false;
//            return false;
//        }
//
//        $driversList = $appConfig['doctrine']['driver'][$driverName]['drivers'];
//
//
//
//        return false;
//    }
//
//    /**
//     * @inheritdoc
//     *
//     * @param ServiceLocatorInterface $serviceLocator
//     * @param                         $name
//     * @param                         $requestedName
//     *
//     * @return mixed
//     *
//     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
//     */
//    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
//    {
//        return false;
//    }


    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return boolean
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function canCreateServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var OrmEntityLocatorInterface $ormEntityLocator */
        $ormEntityLocator = $appServiceLocator->get(OrmEntityLocatorInterface::class);

        return $ormEntityLocator->has($requestedName);
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
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        /** @var OrmEntityLocatorInterface $ormEntityLocator */
        $ormEntityLocator = $serviceLocator->get(OrmEntityLocatorInterface::class);

        return $ormEntityLocator->get($requestedName);
    }
}
