<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use ReflectionClass;


/**
 * Class OrmAbstractFactory
 *
 * @package Nnx\Doctrine\EntityManager
 */
class OrmEntityAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Ключем является имя интерфейса сущности, а значением объект прототип, либо false
     *
     * @var array
     */
    protected $prototype = [];

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
        if (array_key_exists($requestedName, $this->prototype)) {
            return false !== $this->prototype[$requestedName];
        }

        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var OrmEntityLocatorInterface $ormEntityLocator */
        $ormEntityLocator = $appServiceLocator->get(OrmEntityLocatorInterface::class);

        $hasOrmEntity = $ormEntityLocator->has($requestedName);
        if (false === $hasOrmEntity) {
            $this->prototype[$requestedName] = false;
        }

        return $hasOrmEntity;
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
     * @throws Exception\RuntimeException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        if (array_key_exists($requestedName, $this->prototype)) {
            if (!is_object($this->prototype[$requestedName])) {
                $errMsg = sprintf('Invalid prototype for %s', $requestedName);
                throw new Exception\RuntimeException($errMsg);
            }
            return clone $this->prototype[$requestedName];
        }

        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var OrmEntityLocatorInterface $ormEntityLocator */
        $ormEntityLocator = $appServiceLocator->get(OrmEntityLocatorInterface::class);

        $entityClassName = $ormEntityLocator->get($requestedName);

        if ($serviceLocator->has($entityClassName)) {
            $entity = $serviceLocator->get($entityClassName);
        } else {
            $r = new ReflectionClass($entityClassName);
            $entity = $r->newInstance();
        }
        $this->prototype[$requestedName] = $entity;


        return $entity;
    }
}
