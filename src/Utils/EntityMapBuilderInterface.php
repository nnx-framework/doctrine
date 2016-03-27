<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

/**
 * Interface EntityMapBuilderInterface
 *
 * @package Nnx\Doctrine\Utils
 */
interface EntityMapBuilderInterface
{
    /**
     * Подготавливает карту сущностей, для заданного ObjectManager'a
     *
     * @param $objectManagerName
     *
     * @return array
     */
    public function buildEntityMapByObjectManagerName($objectManagerName);
}
