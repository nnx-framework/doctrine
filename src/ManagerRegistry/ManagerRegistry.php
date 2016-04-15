<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ManagerRegistry
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ManagerRegistry extends AbstractManagerRegistry
{
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
    const OBJECT_MANAGER_CONTEXT = 'objectManager';

    /**
     * Контекст вызова метода getService
     *
     * @var string
     */
    const CONNECTION_CONTEXT = 'objectManager';

    /**
     * Контекст вызова метода getService
     *
     * @var string
     */
    protected $serviceContext;

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
     * @param string $name
     *
     * @return mixed
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
     */
    protected function getObjectManagerByName($name)
    {
        // TODO: Implement getObjectManagerByName() method.
    }


    /**
     * Получает соеденение по имени
     *
     * @param $name
     *
     * @return mixed
     */
    protected function getConnectionByName($name)
    {
        // TODO: Implement getConnectionByName() method.
    }



    /**
     * @param string $name
     *
     * @return mixed
     */
    protected function resetService($name)
    {
        // TODO: Implement resetService() method.
    }

    /**
     * @param string $alias
     *
     * @return mixed
     */
    public function getAliasNamespace($alias)
    {
        // TODO: Implement getAliasNamespace() method.
    }
}
