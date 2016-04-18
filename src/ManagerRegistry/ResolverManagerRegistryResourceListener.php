<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Interop\Container\ContainerInterface;

/**
 * Class ResolverManagerRegistryResourceListener
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ResolverManagerRegistryResourceListener extends AbstractListenerAggregate
{

    /**
     * Локатор отвечающий за получение экземпляра ObjectManager'a Doctrine, по его имени
     *
     * @var ContainerInterface
     */
    protected $objectManagerLocator;


    /**
     * Локатор отвечающий за получение соеденения к базе данных, по его имени
     *
     * @var ServiceLocatorInterface
     */
    protected $connectionServiceLocator;

    /**
     * ResolverManagerRegistryResourceListener constructor.
     *
     * @param ContainerInterface $objectManagerLocator
     * @param ServiceLocatorInterface $connectionServiceLocator
     */
    public function __construct(ContainerInterface $objectManagerLocator, ServiceLocatorInterface $connectionServiceLocator)
    {
        $this->setObjectManagerLocator($objectManagerLocator);
        $this->setConnectionServiceLocator($connectionServiceLocator);
    }

    /**
     * @param EventManagerInterface $events
     *
     * @return mixed
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();
        $sharedManager->attach(ManagerRegistry::class, ManagerRegistryResourceEvent::RESOLVE_CONNECTION_EVENT, [$this, 'resolveConnectionByNameHandler']);
        $sharedManager->attach(ManagerRegistry::class, ManagerRegistryResourceEvent::RESOLVE_OBJECT_MANAGER_EVENT, [$this, 'resolveObjectManagerByNameHandler']);
    }

    /**
     * Обработчик события отвечающий за получение ObjectManager'a по его имени
     *
     * @param ManagerRegistryResourceEventInterface $e
     *
     * @return ObjectManager|null
     *
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Interop\Container\Exception\NotFoundException
     */
    public function resolveObjectManagerByNameHandler(ManagerRegistryResourceEventInterface $e)
    {
        $name = $e->getResourceName();
        $objectManagerLocator = $this->getObjectManagerLocator();

        $objectManager = null;
        if ($objectManagerLocator->has($name)) {
            $objectManager = $objectManagerLocator->get($name);
        }

        return $objectManager;
    }


    /**
     * Обработчик события отвечающего за получение соеденения к базе данных, по его имени
     *
     * @param ManagerRegistryResourceEventInterface $e
     *
     * @return mixed
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function resolveConnectionByNameHandler(ManagerRegistryResourceEventInterface $e)
    {
        $name = $e->getResourceName();
        $connectionServiceLocator = $this->getConnectionServiceLocator();

        $connection = null;
        if ($connectionServiceLocator->has($name)) {
            $connection = $connectionServiceLocator->get($name);
        }

        return $connection;
    }

    /**
     * Возвращает  локатор отвечающий за получение экземпляра ObjectManager'a Doctrine, по его имени
     *
     * @return ContainerInterface
     */
    public function getObjectManagerLocator()
    {
        return $this->objectManagerLocator;
    }

    /**
     * Устанавливает локатор отвечающий за получение экземпляра ObjectManager'a Doctrine, по его имени
     *
     * @param ContainerInterface $objectManagerLocator
     *
     * @return $this
     */
    public function setObjectManagerLocator(ContainerInterface $objectManagerLocator)
    {
        $this->objectManagerLocator = $objectManagerLocator;

        return $this;
    }

    /**
     * Возвращает локатор отвечающий за получение соеденения к базе данных, по его имени
     *
     * @return ServiceLocatorInterface
     */
    public function getConnectionServiceLocator()
    {
        return $this->connectionServiceLocator;
    }

    /**
     * Устанавливает локатор отвечающий за получение соеденения к базе данных, по его имени
     *
     * @param ServiceLocatorInterface $connectionServiceLocator
     *
     * @return $this
     */
    public function setConnectionServiceLocator(ServiceLocatorInterface $connectionServiceLocator)
    {
        $this->connectionServiceLocator = $connectionServiceLocator;

        return $this;
    }
}
