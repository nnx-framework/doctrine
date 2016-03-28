<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Hydrator;

use Zend\ServiceManager\AbstractFactoryInterface;
use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject;


/**
 * Class DoctrineObjectHydratorAbstractFactory
 *
 * @package Nnx\Doctrine\Hydrator
 */
class DoctrineObjectHydratorAbstractFactory implements AbstractFactoryInterface
{
    /**
     * Флаг определяет была ли инициализированна фабрика
     *
     * @var bool
     */
    protected $isInit = false;

    /**
     * Контейнер для создания DoctrineObjectHydrator
     *
     * @var DoctrineObjectHydratorLocatorInterface
     */
    protected $doctrineObjectHydratorLocator;

    /**
     * Инициализация фабрики
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return boolean;
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    protected function init(ServiceLocatorInterface $serviceLocator)
    {
        if (true === $this->isInit) {
            return $this->isInit;
        }

        $appServiceLocator = $serviceLocator;
        if ($serviceLocator instanceof AbstractPluginManager) {
            $appServiceLocator = $serviceLocator->getServiceLocator();
        }

        /** @var DoctrineObjectHydratorLocatorInterface $doctrineObjectHydratorLocator */
        $doctrineObjectHydratorLocator = $appServiceLocator->get(DoctrineObjectHydratorLocatorInterface::class);
        $this->setDoctrineObjectHydratorLocator($doctrineObjectHydratorLocator);


        $this->isInit = true;
        return $this->isInit;
    }

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
        $this->init($serviceLocator);
        return $this->getDoctrineObjectHydratorLocator()->has($requestedName);
    }

    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     * @param                         $name
     * @param                         $requestedName
     *
     * @return DoctrineObject
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function createServiceWithName(ServiceLocatorInterface $serviceLocator, $name, $requestedName)
    {
        $this->init($serviceLocator);
        return $this->getDoctrineObjectHydratorLocator()->get($requestedName);
    }

    /**
     * Возвращает контейнер для создания DoctrineObjectHydrator
     *
     * @return DoctrineObjectHydratorLocatorInterface
     */
    public function getDoctrineObjectHydratorLocator()
    {
        return $this->doctrineObjectHydratorLocator;
    }

    /**
     * Устанавливает контейнер для создания DoctrineObjectHydrator
     *
     * @param DoctrineObjectHydratorLocatorInterface $doctrineObjectHydratorLocator
     *
     * @return $this
     */
    public function setDoctrineObjectHydratorLocator(DoctrineObjectHydratorLocatorInterface $doctrineObjectHydratorLocator)
    {
        $this->doctrineObjectHydratorLocator = $doctrineObjectHydratorLocator;

        return $this;
    }
}
