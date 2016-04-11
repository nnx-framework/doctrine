<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Service;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Interface ObjectManagerServiceInterface
 *
 * @package Nnx\Doctrine\Service
 */
interface ObjectManagerServiceInterface
{
    /**
     * По имени сущности получает репозиторий для работы с ней
     *
     * @param $entityName
     *
     * @return ObjectRepository
     */
    public function getRepository($entityName);

    /**
     * Сохраняет сущность в хранилище
     *
     * @param mixed $entityObject
     *
     * @return void
     */
    public function saveEntityObject($entityObject);

    /**
     * Создает и сохраняет новую сущность
     *
     * @param string $entityName
     */
    public function createAndSaveEntityObject($entityName);
}
