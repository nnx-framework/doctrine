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
    const FLAG_PERSIST = 0;
    const FLAG_FLUSH = 1;
    const FLAG_FLUSH_ALL = 2;
    
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
     * @param bool|int $flagFlush
     */
    public function saveEntityObject($entityObject, $flagFlush = self::FLAG_PERSIST);

    /**
     * Создает новую сущность
     *
     * @param string $entityName
     * @param array  $options
     *
     * @return mixed
     */
    public function createEntityObject($entityName, array $options = []);
}
