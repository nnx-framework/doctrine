<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

use Nnx\Doctrine\Options\ModuleOptionsInterface;

/**
 * Class DoctrineOrmModuleConfig
 *
 * @package Nnx\Doctrine\Utils
 */
class DoctrineOrmModuleConfig implements DoctrineOrmModuleConfigInterface
{
    /**
     * Префикс, с которого начинается имя сервиса, для получения ObjectManager'a доктрины
     *
     * @var string
     */
    const DOCTRINE_PREFIX = 'doctrine.entitymanager.';

    /**
     * Конфигурация доктрины.
     *
     * @see https://github.com/doctrine/DoctrineORMModule/blob/0.10.0/config/module.config.php
     *
     * @var array
     */
    protected $doctrineConfig = [];

    /**
     * Ключем является имя ObjectManager'a значением либо массив содержащий имена неймспейсов в которых расположены
     * сущности данного ObjectManager, либо false, в случае если для данного ObjectManager невозможно получить список
     * неймспейсов
     *
     * @var array
     */
    protected $namespacesByObjectManagerCache = [];

    /**
     * Опции модуля
     *
     * @var ModuleOptionsInterface
     */
    protected $moduleOptions;

    /**
     * Список имен ObjectManager'ов
     *
     * @var array|null
     */
    protected $listObjectManagerName;

    /**
     * Список соеденений
     *
     * @var array|null
     */
    protected $listConnectionName;

    /**
     * DoctrineOrmModuleConfig constructor.
     *
     * @param array                  $doctrineConfig
     * @param ModuleOptionsInterface $moduleOptions
     */
    public function __construct(array $doctrineConfig = [], ModuleOptionsInterface $moduleOptions)
    {
        $this->setDoctrineConfig($doctrineConfig);
        $this->setModuleOptions($moduleOptions);
    }


    /**
     * Возвращает конфигурацию доктрины.
     *
     * @return array
     */
    public function getDoctrineConfig()
    {
        return $this->doctrineConfig;
    }

    /**
     * Устанавливает конфигурацию доктрины.
     *
     * @param array $doctrineConfig
     *
     * @return $this
     */
    public function setDoctrineConfig(array $doctrineConfig = [])
    {
        $this->doctrineConfig = $doctrineConfig;

        return $this;
    }

    /**
     * Список ObjectManager'ов декларированных в настройках модуля DoctrineOrmModule
     *
     * @return array
     */
    public function getListObjectManagerName()
    {
        if ($this->listObjectManagerName) {
            return $this->listObjectManagerName;
        }

        if (!$this->isValidDoctrineOrmModuleEntityManagerConfig()) {
            $this->listObjectManagerName = [];
            return $this->listObjectManagerName;
        }

        $doctrineConfig = $this->getDoctrineConfig();

        $listObjectManagerName = array_keys($doctrineConfig['entitymanager']);
        $prepareListObjectManagerName = array_map(function ($objectManagerName) {
            return 'doctrine.entitymanager.' . $objectManagerName;
        }, $listObjectManagerName);

        $this->listObjectManagerName = array_combine($listObjectManagerName, $prepareListObjectManagerName);

        return $this->listObjectManagerName;
    }


    /**
     * Список соиденений декларированных в настройках модуля DoctrineOrmModule
     *
     * @return array
     */
    public function getListConnectionName()
    {
        if ($this->listConnectionName) {
            return $this->listConnectionName;
        }

        if (!$this->isValidDoctrineOrmModuleEntityManagerConfig()) {
            $this->listConnectionName = [];
            return $this->listConnectionName;
        }

        $doctrineConfig = $this->getDoctrineConfig();

        $listConnectionName = array_keys($doctrineConfig['connection']);
        $prepareListConnectionName = array_map(function ($connectionName) {
            return 'doctrine.connection.' . $connectionName;
        }, $listConnectionName);

        $this->listConnectionName = array_combine($listConnectionName, $prepareListConnectionName);

        return $this->listConnectionName;
    }

    /**
     * @inheritdoc
     *
     * @param string $objectManagerServiceName
     *
     * @return boolean
     */
    public function hasNamespacesByObjectManager($objectManagerServiceName)
    {
        if (array_key_exists($objectManagerServiceName, $this->namespacesByObjectManagerCache)) {
            return false !== $this->namespacesByObjectManagerCache[$objectManagerServiceName];
        }

        if (!$this->isValidDoctrineOrmModuleConfig()) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        if (0 !== strpos($objectManagerServiceName, static::DOCTRINE_PREFIX)) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        $objectManagerName = substr($objectManagerServiceName, 23);

        $doctrineConfig = $this->getDoctrineConfig();

        if (!array_key_exists($objectManagerName, $doctrineConfig['entitymanager'])) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        $omConfig = $doctrineConfig['entitymanager'][$objectManagerName];

        if (!is_array($omConfig) || !array_key_exists('configuration', $omConfig) || !is_string($omConfig['configuration'])) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        $confName = $omConfig['configuration'];

        if (!array_key_exists($confName, $doctrineConfig['configuration']) || !is_array($doctrineConfig['configuration'][$confName])) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        $omConfiguration = $doctrineConfig['configuration'][$confName];

        if (!array_key_exists('driver', $omConfiguration) || !is_string($omConfiguration['driver'])) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        $driverName = $omConfiguration['driver'];

        if (!array_key_exists($driverName, $doctrineConfig['driver']) || !is_array($doctrineConfig['driver'][$driverName])) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        $driverConfig = $doctrineConfig['driver'][$driverName];

        if (!array_key_exists('drivers', $driverConfig) || !is_array($driverConfig['drivers'])) {
            $this->namespacesByObjectManagerCache[$objectManagerServiceName] = false;
            return false;
        }

        $this->namespacesByObjectManagerCache[$objectManagerServiceName] = $this->buildIndexNamespaces($driverConfig['drivers']);

        return false !== $this->namespacesByObjectManagerCache[$objectManagerServiceName];
    }

    /**
     * На основе секции drivers, для драйвера EntityManager'a doctrine строит индекс для работы с неймспейсами.
     *
     * Ключем явлеятся тот же ключ что и в $drivers, а значением часть неймспейса в котором распологаются все сущности модуля
     *
     * @param $drivers
     *
     * @return array
     */
    public function buildIndexNamespaces($drivers)
    {
        $listNamespaces = array_keys($drivers);

        $moduleOptions = $this->getModuleOptions();
        $entitySeparator = $moduleOptions->getEntitySeparator();

        $index = [];
        foreach ($listNamespaces as $currentNamespace) {
            $prepareNamespace = rtrim($currentNamespace, '\\');
            $normalizeNamespace = $prepareNamespace . '\\';

            $normalizeNamespaceStack = explode($entitySeparator, $normalizeNamespace);

            $namespacePrefix = array_shift($normalizeNamespaceStack);
            $index[$currentNamespace] = $namespacePrefix . $entitySeparator;
        }

        return $index;
    }

    /**
     * @inheritdoc
     *
     * @param $objectManagerServiceName
     *
     * @return array
     *
     * @throws Exception\EntityNamespacesNotFoundException
     */
    public function getNamespacesIndexByObjectManagerName($objectManagerServiceName)
    {
        if (false === $this->hasNamespacesByObjectManager($objectManagerServiceName)) {
            $errMsh = sprintf('Entity namespaces not found for: %s', $objectManagerServiceName);
            throw new Exception\EntityNamespacesNotFoundException($errMsh);
        }

        return $this->namespacesByObjectManagerCache[$objectManagerServiceName];
    }

    /**
     * Проверяет является ли структура конфига модуля DoctrineORMModule, подходящей для того что бы получить список
     * неймспейсов в которых распологаются сущности для работы заданного ObjectManager'a
     *
     * @return bool
     */
    public function isValidDoctrineOrmModuleConfig()
    {
        $doctrineConfig = $this->getDoctrineConfig();

        return $this->isValidDoctrineOrmModuleEntityManagerConfig()
               && array_key_exists('configuration', $doctrineConfig) && is_array($doctrineConfig['configuration'])
               && array_key_exists('driver', $doctrineConfig) && is_array($doctrineConfig['driver']);
    }

    /**
     * Проверяет есть ли в конфиги корректная секция описывающая настройки entitymanager
     *
     * @return bool
     */
    public function isValidDoctrineOrmModuleEntityManagerConfig()
    {
        $doctrineConfig = $this->getDoctrineConfig();

        return array_key_exists('entitymanager', $doctrineConfig) && is_array($doctrineConfig['entitymanager']);
    }

    /**
     * Возвращает опции модуля
     *
     * @return ModuleOptionsInterface
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * Устанавливает опции модуля
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
