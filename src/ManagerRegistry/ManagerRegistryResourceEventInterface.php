<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Zend\EventManager\EventInterface;


/**
 * Interface ManagerRegistryResourceEventInterface
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
interface ManagerRegistryResourceEventInterface extends EventInterface
{
    /**
     * Возвращает имя ресурса
     *
     * @return string
     */
    public function getResourceName();

    /**
     * Устанавливает имя ресурса
     *
     * @param string $resourceName
     *
     * @return $this
     */
    public function setResourceName($resourceName);
}
