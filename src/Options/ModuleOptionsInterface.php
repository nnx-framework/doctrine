<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Options;

/**
 * Interface ModuleOptionsInterface
 *
 * @package Nnx\Doctrine\Options
 */
interface ModuleOptionsInterface
{
    /**
     * Строка, используемая как разделитель в полном имени класса сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
     *
     * @return string
     */
    public function getEntitySeparator();

    /**
     * Возвращает паттерн по которому из имени интерфейса можно получить строку,
     * являющеюся заготовкой для формирования имени сущности
     *
     * @return string
     */
    public function getEntityBodyNamePattern();

    /**
     * Возвращает строку которая добавляется перед  заготовкой именем сущности полученной в результате
     * примерения @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @return string
     */
    public function getEntityNamePrefix();


    /**
     * Возвращает строку которая добавляется после заготовки имени сущности полученной в результате примерения
     * @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @return string
     */
    public function getEntityNamePostfix();


    /**
     * Возвращает имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache
     *
     * @return string
     */
    public function getEntityMapDoctrineCache();

    /**
     * Возвращает префикс используемый для генерации ключа кеширования карты сущностей doctrine
     *
     * @return string
     */
    public function getEntityMapDoctrineCachePrefix();


    /**
     * Возвращает имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache для кеширования метаданных сущности
     *
     * @return string
     */
    public function getMetadataReaderCache();

    /**
     * Возвращает флаг определяющий, нужно ли автоматически собирать кеш карты сущностей
     *
     * @return boolean
     */
    public function getFlagAutoBuildEntityMapDoctrineCache();


    /**
     * Возвращает список EntityManager'ов, для которых никогда не нужно собирать кеш entityMap  в автоматическом режими
     *
     * @return array
     */
    public function getExcludeEntityManagerForAutoBuildEntityMap();


    /**
     * Возвращает флаг позволяющий отключить использования кеширования при работе с entityMap
     *
     * @return boolean
     */
    public function getFlagDisableUseEntityMapDoctrineCache();


    /**
     * Устанавливает флаг позволяющий отключить использования кеширования при работе с entityMap
     *
     * @param boolean $flagDisableUseEntityMapDoctrineCache
     *
     * @return $this
     */
    public function setFlagDisableUseEntityMapDoctrineCache($flagDisableUseEntityMapDoctrineCache);
}
