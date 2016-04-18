<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Zend\EventManager\Event;

/**
 * Class ManagerRegistryResourceEvent
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ManagerRegistryResourceEvent extends Event implements ManagerRegistryResourceEventInterface
{
    /**
     * Имя события бросаемого когда необходимо получить ObjectManager Doctrine по его имени
     *
     * @var string
     */
    const RESOLVE_OBJECT_MANAGER_EVENT = 'resolveObjectManager.managerRegistryResource';

    /**
     * Имя события бросаемого когда необходимо получить соеденение Doctrine по его имени
     *
     * @var string
     */
    const RESOLVE_CONNECTION_EVENT = 'resolveConnectionManager.managerRegistryResource';

    /**
     * Имя ресурса
     *
     * @var string
     */
    protected $resourceName;

    /**
     * Возвращает имя ресурса
     *
     * @return string
     */
    public function getResourceName()
    {
        return $this->resourceName;
    }

    /**
     * Устанавливает имя ресурса
     *
     * @param string $resourceName
     *
     * @return $this
     */
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;

        return $this;
    }
}
