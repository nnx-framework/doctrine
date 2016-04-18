<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Zend\EventManager\EventManagerAwareTrait;

/**
 * Class ManagerRegistry
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ManagerRegistry extends AbstractManagerRegistry
{
    use EventManagerAwareTrait;

    /**
     * Имя менеджера
     *
     * @var string
     */
    const NAME = 'defaultManagerRegistry';

    /**
     * Контекст вызова метода getService
     *
     * @var string
     */
    const OBJECT_MANAGER_CONTEXT = 'objectManagerContext';

    /**
     * Контекст вызова метода getService
     *
     * @var string
     */
    const CONNECTION_CONTEXT = 'connectionContext';

    /**
     * Контекст вызова метода getService
     *
     * @var string
     */
    protected $serviceContext;

    /**
     * Ключем является имя ObjectManager'a, а значением объект ObjectManager'a
     *
     * @var array
     */
    protected $objectManagerByName = [];

    /**
     * Ключем является имя соеденения, а значением объект соеденения к базе данных
     *
     * @var array
     */
    protected $connectionByName = [];

    /**
     * Прототип для создания объекта события, бросаемого когда нужно получить ресурс
     *
     * @var ManagerRegistryResourceEventInterface
     */
    protected $managerRegistryResourceEventPrototype;

    /**
     * Возвращает прототип для создания объекта события, бросаемого когда нужно получить ресурс
     * 
     * @return ManagerRegistryResourceEventInterface
     */
    public function getManagerRegistryResourceEventPrototype()
    {
        if (null === $this->managerRegistryResourceEventPrototype) {
            $managerRegistryResourceEventPrototype = new ManagerRegistryResourceEvent();
            $this->setManagerRegistryResourceEventPrototype($managerRegistryResourceEventPrototype);
        }
        return $this->managerRegistryResourceEventPrototype;
    }

    /**
     * Устанавливает прототип для создания объекта события, бросаемого когда нужно получить ресурс
     *
     * @param ManagerRegistryResourceEventInterface $managerRegistryResourceEventPrototype
     *
     * @return $this
     */
    public function setManagerRegistryResourceEventPrototype(ManagerRegistryResourceEventInterface $managerRegistryResourceEventPrototype)
    {
        $this->managerRegistryResourceEventPrototype = $managerRegistryResourceEventPrototype;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @param null $name
     *
     * @return mixed
     */
    public function getConnection($name = null)
    {
        $this->serviceContext = static::CONNECTION_CONTEXT;
        $result = parent::getConnection($name);
        $this->serviceContext = null;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getConnections()
    {
        $this->serviceContext = static::CONNECTION_CONTEXT;
        $result = parent::getConnections();
        $this->serviceContext = null;
        return $result;
    }


    /**
     * {@inheritdoc}
     */
    public function getManager($name = null)
    {
        $this->serviceContext = static::OBJECT_MANAGER_CONTEXT;
        $result = parent::getManager($name);
        $this->serviceContext = null;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getManagerForClass($class)
    {
        $this->serviceContext = static::OBJECT_MANAGER_CONTEXT;
        $result = parent::getManagerForClass($class);
        $this->serviceContext = null;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function getManagers()
    {
        $this->serviceContext = static::OBJECT_MANAGER_CONTEXT;
        $result = parent::getManagers();
        $this->serviceContext = null;
        return $result;
    }


    /**
     * @inheritdoc
     *
     * @param string $name
     *
     * @return mixed
     * @throws \Nnx\Doctrine\ManagerRegistry\Exception\ConnectionNotFoundException
     * @throws \Nnx\Doctrine\ManagerRegistry\Exception\ObjectManagerNotFoundException
     * @throws \Nnx\Doctrine\ManagerRegistry\Exception\RuntimeException
     */
    protected function getService($name)
    {
        if (static::OBJECT_MANAGER_CONTEXT === $this->serviceContext) {
            return $this->getObjectManagerByName($name);
        }

        if (static::CONNECTION_CONTEXT === $this->serviceContext) {
            return $this->getConnectionByName($name);
        }

        $errMsg = 'Invalid execution context';
        throw new Exception\RuntimeException($errMsg);
    }

    /**
     * Получает ObjectManager по имени
     *
     * @param $name
     *
     * @return ObjectManager
     * @throws \Nnx\Doctrine\ManagerRegistry\Exception\ObjectManagerNotFoundException
     */
    protected function getObjectManagerByName($name)
    {
        if (array_key_exists($name, $this->objectManagerByName)) {
            return $this->objectManagerByName[$name];
        }

        $event = clone $this->getManagerRegistryResourceEventPrototype();
        $event->setName(ManagerRegistryResourceEvent::RESOLVE_OBJECT_MANAGER_EVENT);
        $event->setResourceName($name);
        $event->setTarget($this);


        $resultsEvent = $this->getEventManager()->trigger($event, function ($objectManager) {
            return $objectManager instanceof ObjectManager;
        });

        $objectManager = $resultsEvent->last();

        if (!$objectManager instanceof ObjectManager) {
            $errMsg = sprintf('Object manager %s not found', $name);
            throw new Exception\ObjectManagerNotFoundException($errMsg);
        }

        $this->objectManagerByName[$name] = $objectManager;

        return $this->objectManagerByName[$name];
    }


    /**
     * Получает соеденение по имени
     *
     * @param $name
     *
     * @return mixed
     * @throws \Nnx\Doctrine\ManagerRegistry\Exception\ConnectionNotFoundException
     */
    protected function getConnectionByName($name)
    {
        if (array_key_exists($name, $this->connectionByName)) {
            return $this->connectionByName[$name];
        }

        $event = clone $this->getManagerRegistryResourceEventPrototype();
        $event->setName(ManagerRegistryResourceEvent::RESOLVE_CONNECTION_EVENT);
        $event->setResourceName($name);
        $event->setTarget($this);


        $resultsEvent = $this->getEventManager()->trigger($event, function ($connection) {
            return is_object($connection);
        });

        $connection = $resultsEvent->last();

        if (!is_object($connection)) {
            $errMsg = sprintf('Connection %s not found', $name);
            throw new Exception\ConnectionNotFoundException($errMsg);
        }

        $this->connectionByName[$name] = $connection;

        return $this->connectionByName[$name];
    }


    /**
     * {@inheritdoc}
     */
    public function resetManager($name = null)
    {
        $this->serviceContext = static::OBJECT_MANAGER_CONTEXT;
        parent::resetManager($name);
        $this->serviceContext = null;
    }

    /**
     * @param string $name
     *
     * @return mixed
     * @throws \Nnx\Doctrine\ManagerRegistry\Exception\ObjectManagerNotFoundException
     */
    protected function resetService($name)
    {
        if (static::OBJECT_MANAGER_CONTEXT === $this->serviceContext) {
            $this->getObjectManagerByName($name)->clear();
        }
    }

    /**
     * @inheritdoc
     *
     * @param string $alias
     *
     * @return mixed
     */
    public function getAliasNamespace($alias)
    {
        return $alias;
    }
}
