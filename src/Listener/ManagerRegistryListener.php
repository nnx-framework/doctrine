<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Listener;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;
use Nnx\Doctrine\ManagerRegistry\ManagerRegistry;

/**
 * Class ResolverManagerRegistryResourceListener
 *
 * @package Nnx\Doctrine\Listener
 */
class ManagerRegistryListener extends AbstractListenerAggregate
{

    /**
     * ManagerRegistry
     *
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * ResolverManagerRegistryResourceListener constructor.
     *
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->setManagerRegistry($managerRegistry);
    }

    /**
     * @param EventManagerInterface $events
     *
     * @return mixed
     */
    public function attach(EventManagerInterface $events)
    {
        $sharedManager = $events->getSharedManager();
        $sharedManager->attach('DoctrineManagerRegistry', 'get.doctrineManagerRegistry', [$this, 'getDoctrineManagerRegistryHandler']);
    }

    /**
     * Обработчик события возникающего когда происходит попытка получить экземпляр ManagerRegistry
     *
     * @return ManagerRegistry
     */
    public function getDoctrineManagerRegistryHandler()
    {
        return $this->getManagerRegistry();
    }



    /**
     * Возвращает ManagerRegistry
     *
     * @return ManagerRegistry
     */
    public function getManagerRegistry()
    {
        return $this->managerRegistry;
    }

    /**
     * Устанавливает ManagerRegistry
     *
     * @param ManagerRegistry $managerRegistry
     *
     * @return $this
     */
    public function setManagerRegistry(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;

        return $this;
    }
}
