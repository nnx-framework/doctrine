<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\Options\ModuleOptionsInterface;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigInterface;
use Nnx\Doctrine\Utils\EntityMapCacheInterface;
use ReflectionClass;

/**
 * Class OrmAbstractFactory
 *
 * @package Nnx\Doctrine\EntityManager
 */
class EntityMapAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Ключем является имя интерфейса сущности, а значением объект прототип, либо false
     *
     * @var array
     */
    protected $prototype = [];

    /**
     * Флаг определяет была ли инициированна фабрика
     *
     * @var bool
     */
    protected $isInit = false;

    /**
     * Настройки модуля
     *
     * @var ModuleOptionsInterface
     */
    protected $moduleOptions;

    /**
     * Ключем является имя objectManager'a, а значением карта сущностей для него
     *
     * @var array
     */
    protected $objectManagerToEntityMap = [];

    /**
     * Колличество ObjectManagers для которых есть EntityMap
     *
     * @var int
     */
    protected $countObjectManagers = 0;

    /**
     * В случае если EntityMap есть только для одного ObjectManager, то данное свойство будет содержать эту EntityMap
     *
     * @var array
     */
    protected $baseEntityMap = [];

    /**
     * Ключем является имя интерфейса,  а значением имя класса сущности
     *
     * @var array
     */
    protected $interfaceNameToClassName = [];

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
        $this->init($serviceLocator);
        if (array_key_exists($requestedName, $this->prototype)) {
            return false !== $this->prototype[$requestedName];
        }

        return false !== $this->getClassNameByInterface($requestedName);
    }

    /**
     * Попытка получить имя класса, на оснве интерфейса
     *
     * @param $interfaceName
     *
     * @return string|false
     */
    protected function getClassNameByInterface($interfaceName)
    {
        if (array_key_exists($interfaceName, $this->interfaceNameToClassName)) {
            return $this->interfaceNameToClassName[$interfaceName];
        }

        if (0 === $this->countObjectManagers) {
            $this->interfaceNameToClassName[$interfaceName] = false;
            return false;
        } elseif (1 === $this->countObjectManagers) {
            $this->interfaceNameToClassName[$interfaceName] = array_key_exists($interfaceName, $this->baseEntityMap) ? $this->baseEntityMap[$interfaceName] : false;
            return $this->interfaceNameToClassName[$interfaceName];
        }

        foreach ($this->objectManagerToEntityMap as $entityMap) {
            if (array_key_exists($interfaceName, $entityMap)) {
                $this->interfaceNameToClassName[$interfaceName] = $entityMap[$interfaceName];
                return $this->interfaceNameToClassName[$interfaceName];
            }
        }
        $this->interfaceNameToClassName[$interfaceName] = false;
        return $this->interfaceNameToClassName[$interfaceName];
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
     * @throws Exception\RuntimeException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $this->init($serviceLocator);

        if (array_key_exists($requestedName, $this->prototype)) {
            if (!is_object($this->prototype[$requestedName])) {
                $errMsg = sprintf('Invalid prototype for %s', $requestedName);
                throw new Exception\RuntimeException($errMsg);
            }
            return clone $this->prototype[$requestedName];
        }

        $className = $this->getClassNameByInterface($requestedName);
        if (false === $className) {
            $errMsg = sprintf('Invalid cache date for  %s', $requestedName);
            throw new Exception\RuntimeException($errMsg);
        }

        if ($serviceLocator->has($className)) {
            $entity = $serviceLocator->get($className);
        } else {
            $r = new ReflectionClass($className);
            $entity = $r->newInstance();
        }
        $this->prototype[$requestedName] = $entity;

        return $entity;
    }

    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return void
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function init(ServiceLocatorInterface $serviceLocator)
    {
        if (true === $this->isInit) {
            return;
        }

        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsManager */
        $moduleOptionsManager = $appServiceLocator->get(ModuleOptionsPluginManagerInterface::class);
        /** @var ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $moduleOptionsManager->get(ModuleOptionsInterface::class);
        $this->setModuleOptions($moduleOptions);

        /** @var DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig */
        $doctrineOrmModuleConfig = $appServiceLocator->get(DoctrineOrmModuleConfigInterface::class);

        $listObjectManagerName = $doctrineOrmModuleConfig->getListObjectManagerName();

        /** @var EntityMapCacheInterface $entityMapCache */
        $entityMapCache = $appServiceLocator->get(EntityMapCacheInterface::class);
        foreach ($listObjectManagerName as $objectManagerName) {
            if ($entityMapCache->hasEntityMap($objectManagerName)) {
                $this->objectManagerToEntityMap[$objectManagerName] = $entityMapCache->loadEntityMap($objectManagerName);
            }
        }

        $this->countObjectManagers = count($this->objectManagerToEntityMap);

        if (1 === $this->countObjectManagers) {
            reset($this->objectManagerToEntityMap);
            $this->baseEntityMap = current($this->objectManagerToEntityMap);
        }

        $this->isInit = true;
    }

    /**
     * Возвращает настройки модуля
     *
     * @return ModuleOptionsInterface
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * Устанавливает настройки модуля
     *
     * @param ModuleOptionsInterface $moduleOptions
     *
     * @return $this
     */
    public function setModuleOptions($moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;

        return $this;
    }
}
