<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

use Doctrine\Common\Cache\Cache;
use Nnx\Doctrine\Options\ModuleOptionsInterface;

/**
 * Class EntityMapCache
 *
 * @package Nnx\Doctrine\Utils
 */
class EntityMapCache implements EntityMapCacheInterface
{
    /**
     * Сервис для построения карты сущностей Doctrine2
     *
     * @var EntityMapBuilderInterface
     */
    protected $entityMapBuilder;

    /**
     * Кеш в который сохрянется карта сущностей Doctrine2
     *
     * @var Cache
     */
    protected $cache;

    /**
     * Объект с настройками модуля
     *
     * @var ModuleOptionsInterface
     */
    protected $moduleOptions;

    /**
     * Ключ кеширования
     *
     * @var array
     */
    protected $cacheKeys = [];

    /**
     * EntityMapCache constructor.
     *
     * @param EntityMapBuilderInterface $entityMapBuilder
     * @param Cache                     $cache
     * @param ModuleOptionsInterface    $moduleOptions
     */
    public function __construct(
        EntityMapBuilderInterface $entityMapBuilder,
        Cache $cache,
        ModuleOptionsInterface $moduleOptions
    ) {
        $this->setEntityMapBuilder($entityMapBuilder);
        $this->setCache($cache);
        $this->setModuleOptions($moduleOptions);
    }

    /**
     * @inheritdoc
     *
     * @param $objectManagerName
     *
     * @return boolean
     */
    public function saveEntityMap($objectManagerName)
    {
        $map = $this->getEntityMapBuilder()->buildEntityMapByObjectManagerName($objectManagerName);

        $key = $this->getCacheKeyForObjectManagerName($objectManagerName);

        return $this->getCache()->save($key, $map);
    }

    /**
     * Загружает карту сущностей
     *
     * @param $objectManagerName
     *
     * @return array|null
     */
    public function loadEntityMap($objectManagerName)
    {
        $key = $this->getCacheKeyForObjectManagerName($objectManagerName);

        $cache = $this->getCache();

        if (false === $cache->contains($key)) {
            return false;
        }

        return $cache->fetch($key);
    }

    /**
     * Удаляет карту сущностей
     *
     * @param $objectManagerName
     *
     * @return void
     */
    public function deleteEntityMap($objectManagerName)
    {
        $key = $this->getCacheKeyForObjectManagerName($objectManagerName);

        $cache = $this->getCache();

        if (true === $cache->contains($key)) {
            $cache->delete($key);
        }
    }

    /**
     * Проверяет есть ли в кеше карта сущностей для заданного ObjectManager
     *
     * @param $objectManagerName
     *
     * @return bool
     */
    public function hasEntityMap($objectManagerName)
    {
        $key = $this->getCacheKeyForObjectManagerName($objectManagerName);

        return $this->getCache()->contains($key);
    }

    /**
     * Получает ключ для кеширования карты сущностей
     *
     * @param $objectManagerName
     *
     * @return string
     */
    public function getCacheKeyForObjectManagerName($objectManagerName)
    {
        if (array_key_exists($objectManagerName, $this->cacheKeys)) {
            return $this->cacheKeys[$objectManagerName];
        }

        $preffix = $this->getModuleOptions()->getEntityMapDoctrineCachePrefix();
        $key = $preffix . '_' . $objectManagerName;

        $this->cacheKeys[$objectManagerName] = $key;

        return $this->cacheKeys[$objectManagerName];
    }

    /**
     * @return EntityMapBuilderInterface
     */
    public function getEntityMapBuilder()
    {
        return $this->entityMapBuilder;
    }

    /**
     * @param EntityMapBuilderInterface $entityMapBuilder
     *
     * @return $this
     */
    public function setEntityMapBuilder(EntityMapBuilderInterface $entityMapBuilder)
    {
        $this->entityMapBuilder = $entityMapBuilder;

        return $this;
    }

    /**
     * @return Cache
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param Cache $cache
     *
     * @return $this
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;

        return $this;
    }

    /**
     * Возвращает объект с настройками модуля
     *
     * @return ModuleOptionsInterface
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * Устанавливает  объект с настройками модуля
     *
     * @param ModuleOptionsInterface $moduleOptions
     *
     * @return $this
     */
    public function setModuleOptions(ModuleOptionsInterface $moduleOptions)
    {
        $this->moduleOptions = $moduleOptions;

        return $this;
    }
}
