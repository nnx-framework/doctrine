<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Options;

use Zend\Stdlib\AbstractOptions;
use Nnx\ModuleOptions\ModuleOptionsInterface;
use Nnx\Doctrine\Options\ModuleOptionsInterface as CurrentModuleOptionsInterface;


/**
 * Class ModuleOptions
 *
 * @package Nnx\Doctrine\Options
 */
class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface, CurrentModuleOptionsInterface
{
    /**
     * Строка, используемая как разделитель в полном имени класса сущности(или интерфейса), которая разделяет неймспейс
     * на две части: 1) Нейсмпейс в котором расположенные все сущности 2) Постфикс указывающий на кокнетную сущность.
     * Например \Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\TestEntity\TestEntityInterface
     * 1) Разделителем будет \Entity\
     * 2) Неймспейс в котром расположены все сущности будет \Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\
     * 3) Постфикс указывающий на кокнетную сущность будет TestEntity\TestEntityInterface
     *
     * @var string
     */
    protected $entitySeparator;

    /**
     * Паттерн по которому из имени интерфейса можно получить строку, являющеюся заготовкой для формирования имени сущности
     *
     * @var string
     */
    protected $entityBodyNamePattern;

    /**
     * Строка которая добавляется перед  заготовкой имени сущности полученной в результате
     * примерения @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @var string
     */
    protected $entityNamePrefix;

    /**
     * Строка которая добавляется после заготовки имени сущности полученной в результате примерения
     * @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @var string
     */
    protected $entityNamePostfix;

    /**
     * Имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache
     *
     * (@see https://github.com/doctrine/DoctrineModule)
     * (@see vendor/doctrine/doctrine-module/config/module.config.php)
     * (@see \DoctrineModule\Service\CacheFactory)
     *
     * @var string
     */
    protected $entityMapDoctrineCache;

    /**
     * Префикс используемы для генерации ключа кеширования карты сущностей doctrine
     *
     * @var string
     */
    protected $entityMapDoctrineCachePrefix;

    /**
     * Имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache для кеширования метаданных сущности
     *
     * (@see https://github.com/doctrine/DoctrineModule)
     * (@see vendor/doctrine/doctrine-module/config/module.config.php)
     * (@see \DoctrineModule\Service\CacheFactory)
     *
     * @var string
     */
    protected $metadataReaderCache;

    /**
     * Флаг определяет, нужно ли автоматически собирать кеш карты сущностей
     *
     * @var boolean
     */
    protected $flagAutoBuildEntityMapDoctrineCache = true;

    /**
     * Список EntityManager'ов, для которых никогда не нужно собирать кеш entityMap  в автоматическом режими
     *
     * @var array
     */
    protected $excludeEntityManagerForAutoBuildEntityMap = [];

    /**
     * Флаг позволяет отключить использования кеширования при работе с entityMap
     *
     * @var bool
     */
    protected $flagDisableUseEntityMapDoctrineCache = false;

    /**
     * Строка, используемая как разделитель в полном имени класса сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
     *
     * @return string
     */
    public function getEntitySeparator()
    {
        return $this->entitySeparator;
    }

    /**
     * Устанавливает строку используемую как разделитель в полном имени класса сущности (@see \Nnx\Doctrine\Options\ModuleOptions::$entitySeparator)
     *
     * @param string $entitySeparator
     *
     * @return $this
     */
    public function setEntitySeparator($entitySeparator)
    {
        $this->entitySeparator = $entitySeparator;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getEntityBodyNamePattern()
    {
        return $this->entityBodyNamePattern;
    }

    /**
     * Устанавливает паттерн по которому из имени интерфейса можно получить строку,
     * являющеюся заготовкой для формирования имени сущности
     *
     * @param string $entityBodyNamePattern
     *
     * @return $this
     */
    public function setEntityBodyNamePattern($entityBodyNamePattern)
    {
        $this->entityBodyNamePattern = $entityBodyNamePattern;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getEntityNamePrefix()
    {
        return $this->entityNamePrefix;
    }

    /**
     * Устанавливает строку которая добавляется перед  заготовкой именем сущности полученной в результате
     * примерения @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @param string $entityNamePrefix
     *
     * @return $this
     */
    public function setEntityNamePrefix($entityNamePrefix)
    {
        $this->entityNamePrefix = $entityNamePrefix;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getEntityNamePostfix()
    {
        return $this->entityNamePostfix;
    }

    /**
     * Устанавливает строку которая добавляется после заготовки имени сущности полученной в результате примерения
     * @see \Nnx\Doctrine\Options\ModuleOptions::$entityBodyNamePattern к имени интерфейса.
     *
     * @param string $entityNamePostfix
     *
     * @return $this
     */
    public function setEntityNamePostfix($entityNamePostfix)
    {
        $this->entityNamePostfix = $entityNamePostfix;

        return $this;
    }

    /**
     * Возвращает имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache
     *
     * @return string
     */
    public function getEntityMapDoctrineCache()
    {
        return $this->entityMapDoctrineCache;
    }

    /**
     * Устанавливает имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache
     *
     * @param string $entityMapDoctrineCache
     *
     * @return $this
     */
    public function setEntityMapDoctrineCache($entityMapDoctrineCache)
    {
        $this->entityMapDoctrineCache = $entityMapDoctrineCache;

        return $this;
    }

    /**
     * Возвращает префикс используемы для генерации ключа кеширования карты сущностей doctrine
     *
     * @return string
     */
    public function getEntityMapDoctrineCachePrefix()
    {
        return $this->entityMapDoctrineCachePrefix;
    }

    /**
     * Возвращает префикс используемы для генерации ключа кеширования карты сущностей doctrine
     *
     * @param string $entityMapDoctrineCachePrefix
     *
     * @return $this
     */
    public function setEntityMapDoctrineCachePrefix($entityMapDoctrineCachePrefix)
    {
        $this->entityMapDoctrineCachePrefix = $entityMapDoctrineCachePrefix;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return string
     */
    public function getMetadataReaderCache()
    {
        return $this->metadataReaderCache;
    }

    /**
     * Устанавливает имя сервиса, позволяющего получить объект кеша из модуля doctrine/cache для кеширования метаданных сущности
     *
     * @param string $metadataReaderCache
     *
     * @return $this
     */
    public function setMetadataReaderCache($metadataReaderCache)
    {
        $this->metadataReaderCache = $metadataReaderCache;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return boolean
     */
    public function getFlagAutoBuildEntityMapDoctrineCache()
    {
        return $this->flagAutoBuildEntityMapDoctrineCache;
    }

    /**
     * Устанавливает флаг определяющий, нужно ли автоматически собирать кеш карты сущностей
     *
     * @param bool $flagAutoBuildEntityMapDoctrineCache
     *
     * @return $this
     */
    public function setFlagAutoBuildEntityMapDoctrineCache($flagAutoBuildEntityMapDoctrineCache)
    {
        $this->flagAutoBuildEntityMapDoctrineCache = $flagAutoBuildEntityMapDoctrineCache;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getExcludeEntityManagerForAutoBuildEntityMap()
    {
        return $this->excludeEntityManagerForAutoBuildEntityMap;
    }

    /**
     * Устанавливает список EntityManager'ов, для которых никогда не нужно собирать кеш entityMap  в автоматическом режими
     *
     * @param array $excludeEntityManagerForAutoBuildEntityMap
     *
     * @return $this
     */
    public function setExcludeEntityManagerForAutoBuildEntityMap(array $excludeEntityManagerForAutoBuildEntityMap = [])
    {
        $this->excludeEntityManagerForAutoBuildEntityMap = $excludeEntityManagerForAutoBuildEntityMap;

        return $this;
    }

    /**
     * @inheritdoc
     *
     * @return boolean
     */
    public function getFlagDisableUseEntityMapDoctrineCache()
    {
        return $this->flagDisableUseEntityMapDoctrineCache;
    }

    /**
     * @inheritdoc
     *
     * @param boolean $flagDisableUseEntityMapDoctrineCache
     *
     * @return $this
     */
    public function setFlagDisableUseEntityMapDoctrineCache($flagDisableUseEntityMapDoctrineCache)
    {
        $this->flagDisableUseEntityMapDoctrineCache = $flagDisableUseEntityMapDoctrineCache;

        return $this;
    }
}
