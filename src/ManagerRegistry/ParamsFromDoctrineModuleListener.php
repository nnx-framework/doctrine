<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigInterface;

/**
 * Class ManagerRegistry
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ParamsFromDoctrineModuleListener extends AbstractListenerAggregate
{

    /**
     * Набор слушателей для SharedManager'a
     *
     * @var array
     */
    protected $sharedManagerListeners = [];

    /**
     * Утилита для работы с конфигами DoctrineORMModule
     *
     * @var DoctrineOrmModuleConfigInterface
     */
    protected $doctrineOrmModuleConfig;

    /**
     * ParamsFromDoctrineModuleListener constructor.
     *
     * @param DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig
     */
    public function __construct(DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig)
    {
        $this->setDoctrineOrmModuleConfig($doctrineOrmModuleConfig);
    }

    /**
     * @param EventManagerInterface $events
     *
     * @return mixed
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();
        $sharedManager->attach(ManagerRegistryFactory::class, ManagerRegistryFactory::EVENT_BUILD_LIST_CONNECTIONS, [$this, 'buildListConnectionsHandler']);
        $sharedManager->attach(ManagerRegistryFactory::class, ManagerRegistryFactory::EVENT_BUILD_LIST_OBJECT_MANAGERS, [$this, 'buildListObjectManagersHandler']);
    }

    /**
     * Обработчик события бросаемого когда необходимо получить список доступных подключений
     *
     * @return array
     */
    public function buildListConnectionsHandler()
    {
        return $this->getDoctrineOrmModuleConfig()->getListConnectionName();
    }


    /**
     * Обработчик события бросаемого когда необходимо получить список доступных ObjectManagers's
     *
     * @return array
     */
    public function buildListObjectManagersHandler()
    {
        return $this->getDoctrineOrmModuleConfig()->getListObjectManagerName();
    }

    /**
     *  Возвращает утилиту для работы с конфигами DoctrineORMModule
     *
     * @return DoctrineOrmModuleConfigInterface
     */
    public function getDoctrineOrmModuleConfig()
    {
        return $this->doctrineOrmModuleConfig;
    }

    /**
     * Устанавливает утилиту для работы с конфигами DoctrineORMModule
     *
     * @param DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig
     *
     * @return $this
     */
    public function setDoctrineOrmModuleConfig(DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig)
    {
        $this->doctrineOrmModuleConfig = $doctrineOrmModuleConfig;

        return $this;
    }
}
