<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager;

/**
 * Interface ObjectManagerAutoDetectorInterface
 *
 * @package Nnx\Doctrine\ObjectManager
 */
interface ObjectManagerAutoDetectorInterface
{
    /**
     * Получает имя используемого в модуле ObjectManager'a Doctrine, по имени любого класса модуля
     *
     * @param $className
     *
     * @return string
     */
    public function getObjectManagerNameByClassName($className);

    /**
     * Проверяет есть ли возможность по имени класса модуля, получить имя objectManager'a который используется в данном модуле
     *
     * @param $className
     *
     * @return boolean
     */
    public function hasObjectManagerNameByClassName($className);
}
