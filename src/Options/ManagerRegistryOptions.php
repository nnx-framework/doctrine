<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Options;

use Zend\Stdlib\AbstractOptions;
use Doctrine\Common\Persistence\Proxy;

/**
 * Class ManagerRegistryOptions
 *
 * @package Nnx\Doctrine\Options
 */
class ManagerRegistryOptions extends AbstractOptions
{
    /**
     * Имя соеденений которые можно использовать в \Nnx\Doctrine\ManagerRegistry\ManagerRegistry
     *
     * @var array
     */
    protected $connections = [];

    /**
     * Имена ObjectManager's которые можно использовать в \Nnx\Doctrine\ManagerRegistry\ManagerRegistry
     *
     * @var array
     */
    protected $objectManagers = [];

    /**
     * Имя соеденения по умолчанию
     *
     * @var string
     */
    protected $defaultConnection;

    /**
     * Имя ObjectManager'a по умолчанию
     *
     * @var string
     */
    protected $defaultManager;

    /**
     * Имя прокси интерфейса
     *
     * @var string
     */
    protected $proxyInterfaceName = Proxy::class;

    /**
     * Возвращает имя соеденений которые можно использовать в \Nnx\Doctrine\ManagerRegistry\ManagerRegistry
     *
     * @return array
     */
    public function getConnections()
    {
        return $this->connections;
    }

    /**
     * Устанавливает имя соеденений которые можно использовать в \Nnx\Doctrine\ManagerRegistry\ManagerRegistry
     *
     * @param array $connections
     *
     * @return $this
     */
    public function setConnections(array $connections = [])
    {
        $this->connections = $connections;

        return $this;
    }

    /**
     * Возвращает имена ObjectManager's которые можно использовать в \Nnx\Doctrine\ManagerRegistry\ManagerRegistry
     *
     * @return array
     */
    public function getObjectManagers()
    {
        return $this->objectManagers;
    }

    /**
     * Устанавливает имена ObjectManager's которые можно использовать в \Nnx\Doctrine\ManagerRegistry\ManagerRegistry
     *
     * @param array $objectManagers
     *
     * @return $this
     */
    public function setObjectManagers(array $objectManagers = [])
    {
        $this->objectManagers = $objectManagers;

        return $this;
    }

    /**
     * Возвращает имя соеденения по умолчанию
     *
     * @return string
     */
    public function getDefaultConnection()
    {
        return $this->defaultConnection;
    }

    /**
     * Устанавливает имя соеденения по умолчанию
     *
     * @param string $defaultConnection
     *
     * @return $this
     */
    public function setDefaultConnection($defaultConnection)
    {
        $this->defaultConnection = (string)$defaultConnection;

        return $this;
    }

    /**
     * Возвращает имя ObjectManager'a по умолчанию
     *
     * @return string
     */
    public function getDefaultManager()
    {
        return $this->defaultManager;
    }

    /**
     * Устанавливает имя ObjectManager'a по умолчанию
     *
     * @param string $defaultManager
     *
     * @return $this
     */
    public function setDefaultManager($defaultManager)
    {
        $this->defaultManager = (string)$defaultManager;

        return $this;
    }

    /**
     * Возвращает имя прокси интерфейса
     *
     * @return string
     */
    public function getProxyInterfaceName()
    {
        return $this->proxyInterfaceName;
    }

    /**
     * Устанавливает имя прокси интерфейса
     *
     * @param string $proxyInterfaceName
     *
     * @return $this
     */
    public function setProxyInterfaceName($proxyInterfaceName)
    {
        $this->proxyInterfaceName = (string)$proxyInterfaceName;

        return $this;
    }
}
