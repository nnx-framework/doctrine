<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

/**
 * Interface DoctrineOrmModuleConfigInterface
 *
 * @package Nnx\Doctrine\Utils
 */
interface DoctrineOrmModuleConfigInterface
{
    /**
     * По имени ObjectManager'a определяет есть ли возможность получить, список неймспейсов в которых расположены сущности,
     * с которыми работает данный ObjectManager
     *
     * @param string $objectManagerServiceName
     *
     * @return boolean
     */
    public function hasNamespacesByObjectManager($objectManagerServiceName);


    /**
     * По имени ObjectManager'a получает список неймспейсов в которых расположены сущности,
     * с которыми работает данный ObjectManager.
     *
     * Ключем явлеятся неймспейс указанный настройках драйвера для ObjectManager, а значением часть неймспейса
     * в котором распологаются все сущности модуля
     *
     * @param $objectManagerServiceName
     *
     * @return array
     */
    public function getNamespacesIndexByObjectManagerName($objectManagerServiceName);


    /**
     * Список ObjectManager'ов декларированных в настройках модуля DoctrineOrmModule
     *
     * @return array
     */
    public function getListObjectManagerName();
}
