<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

/**
 * Interface EntityMapCacheInterface
 *
 * @package Nnx\Doctrine\Utils
 */
interface EntityMapCacheInterface
{
    /**
     * Сохраняет в кеше карту сущностей для ObjectManager'a с заданным именем
     *
     * @param $objectManagerName
     *
     * @return boolean Определяет успешно ли были сохранены данные
     */
    public function saveEntityMap($objectManagerName);


    /**
     * Загружает карту сущностей
     *
     * @param $objectManagerName
     *
     * @return array|null
     */
    public function loadEntityMap($objectManagerName);


    /**
     * Удаляет карту сущностей
     *
     * @param $objectManagerName
     *
     * @return void
     */
    public function deleteEntityMap($objectManagerName);
}
