<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager;

/**
 * Interface ObjectManagerNameProviderInterface
 *
 * @package Nnx\Doctrine\ObjectManager
 */
interface ObjectManagerNameProviderInterface
{

    /**
     * Возвращает имя используемого ObjectManager'a
     *
     * @return string
     */
    public function getObjectManagerName();

    /**
     * Устанавливает имя используемого ObjectManager
     *
     * @param string $objectManagerName
     *
     * @return $this
     */
    public function setObjectManagerName($objectManagerName);
}
