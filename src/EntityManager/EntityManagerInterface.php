<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Interop\Container\ContainerInterface;


/**
 * Interface EntityManagerInterface
 *
 * @package Nnx\Doctrine\EntityManager
 */
interface EntityManagerInterface extends ContainerInterface
{

    /**
     * Получение класс сущности, по интерфейсу
     *
     * @param $interfaceName
     *
     * @return string
     */
    public function getEntityClassByInterface($interfaceName);

    /**
     * Проверяет можно ли по имени интерфейса получить имя класса сущности
     *
     * @param $interfaceName
     *
     * @return boolean
     */
    public function hasEntityClassByInterface($interfaceName);
}
