<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\Options\ModuleOptions;
use Nnx\Doctrine\Options\ModuleOptionsInterface;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigInterface;
use ReflectionClass;


/**
 * Class OrmAbstractFactory
 *
 * @package Nnx\Doctrine\EntityManager
 */
class OrmEntityLocator implements OrmEntityLocatorInterface
{
    /**
     * @var array
     */
    protected $entityClassNameCache = [];

    /**
     * @var ObjectManagerAutoDetectorInterface
     */
    protected $objectManagerAutoDetector;

    /**
     * Настройки модуля
     *
     * @var ModuleOptions
     */
    protected $moduleOptions;

    /**
     * Утилита для работы с конфигами модуля DoctrineORMModule
     *
     * @var DoctrineOrmModuleConfigInterface
     */
    protected $doctrineOrmModuleConfig;

    /**
     * Ключем является имя интерфейса сущности, а значением постфикс сущности
     *
     * @var array
     */
    protected $interfaceNameToEntityPostfix = [];

    /**
     * OrmEntityLocator constructor.
     *
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     * @param ModuleOptionsInterface             $moduleOptions
     * @param DoctrineOrmModuleConfigInterface   $doctrineOrmModuleConfig
     */
    public function __construct(
        ObjectManagerAutoDetectorInterface $objectManagerAutoDetector,
        ModuleOptionsInterface $moduleOptions,
        DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig
    ) {
        $this->setObjectManagerAutoDetector($objectManagerAutoDetector);
        $this->setModuleOptions($moduleOptions);
        $this->setDoctrineOrmModuleConfig($doctrineOrmModuleConfig);
    }


    /**
     * @inheritdoc
     *
     * @param string $id
     *
     * @return string
     *
     * @throws Exception\ErrorBuildEntityPostfixException
     * @throws Exception\ErrorBuildEntityClassNameException
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            $errMsg = sprintf('Failed to get the name of the class nature of the interface %s', $id);
            throw new Exception\ErrorBuildEntityClassNameException($errMsg);
        }

        return $this->entityClassNameCache[$id];
    }

    /**
     * @inheritdoc
     *
     * @param string $id
     *
     * @return boolean
     *
     * @throws Exception\ErrorBuildEntityPostfixException
     */
    public function has($id)
    {
        if (array_key_exists($id, $this->entityClassNameCache)) {
            return false !== $this->entityClassNameCache[$id];
        }

        $objectManagerAutoDetector = $this->getObjectManagerAutoDetector();
        if (!$objectManagerAutoDetector->hasObjectManagerNameByClassName($id)) {
            $this->entityClassNameCache[$id] = false;
            return false;
        }
        $objectManagerName = $objectManagerAutoDetector->getObjectManagerNameByClassName($id);

        $doctrineOrmModuleConfig = $this->getDoctrineOrmModuleConfig();
        if (!$doctrineOrmModuleConfig->hasNamespacesByObjectManager($objectManagerName)) {
            $this->entityClassNameCache[$id] = false;
            return false;
        }

        $namespacesIndex = $doctrineOrmModuleConfig->getNamespacesIndexByObjectManagerName($objectManagerName);

        if (false === $this->hasEntityPostfixByInterfaceName($id)) {
            $this->entityClassNameCache[$id] = false;
            return false;
        }
        $entityPostfix = $this->getEntityPostfixByInterfaceName($id);

        $entityClassName = $this->resolveEntityClassName($entityPostfix, $namespacesIndex, $id);

        $this->entityClassNameCache[$id] = $entityClassName;

        return false !== $this->entityClassNameCache[$id];
    }

    /**
     * Поиск имени класса сущности
     *
     * @param string $entityPostfix
     * @param array  $namespacesIndex
     * @param string $entityInterface
     *
     * @return bool|string
     */
    public function resolveEntityClassName($entityPostfix, array $namespacesIndex = [], $entityInterface)
    {
        $entityClassName = false;
        foreach ($namespacesIndex as $rootNamespace) {
            $currentEntityClassName = $rootNamespace . $entityPostfix;
            if (class_exists($currentEntityClassName)) {
                $r = new ReflectionClass($currentEntityClassName);
                if ($r->implementsInterface($entityInterface)) {
                    $entityClassName = $currentEntityClassName;
                    break;
                }
            }
        }

        return $entityClassName;
    }

    /**
     * Проверяет можно ли получить постфикс имени сущности, на основе имени интерфейса
     *
     * @param $entityInterfaceName
     *
     * @return bool
     */
    public function hasEntityPostfixByInterfaceName($entityInterfaceName)
    {
        if (!array_key_exists($entityInterfaceName, $this->interfaceNameToEntityPostfix)) {
            $has = false !== $this->buildEntityPostfixByInterfaceName($entityInterfaceName);
        } else {
            $has = false !== $this->interfaceNameToEntityPostfix[$entityInterfaceName];
        }

        return $has;
    }

    /**
     *  По имени интерфейса получает постфикс имени сущности, либо возвращает false - если не удалось это сделать
     *
     * @param $entityInterfaceName
     *
     * @return string|bool
     */
    public function buildEntityPostfixByInterfaceName($entityInterfaceName)
    {
        $moduleOptions = $this->getModuleOptions();

        $delimiter = $moduleOptions->getEntitySeparator();

        $stackEntityInterfaceName = explode($delimiter, $entityInterfaceName);

        if (2 !== count($stackEntityInterfaceName)) {
            $this->interfaceNameToEntityPostfix[$entityInterfaceName] = false;
            return false;
        }

        $postfixEntityInterfaceName = array_pop($stackEntityInterfaceName);

        $stackPostfixEntityInterfaceName = explode('\\', $postfixEntityInterfaceName);

        $interfaceName = array_pop($stackPostfixEntityInterfaceName);

        $entityBodyNamePattern = $moduleOptions->getEntityBodyNamePattern();

        $entityBodyNameOutput = [];
        preg_match($entityBodyNamePattern, $interfaceName, $entityBodyNameOutput);

        if (2 !== count($entityBodyNameOutput)) {
            $this->interfaceNameToEntityPostfix[$entityInterfaceName] = false;
            return false;
        }
        $entityBodyName =  array_pop($entityBodyNameOutput);

        $prefix = $moduleOptions->getEntityNamePrefix();
        $postfix = $moduleOptions->getEntityNamePostfix();

        $entityName = $prefix . $entityBodyName . $postfix;

        $stackPostfixEntityInterfaceName[] = $entityName;

        $entityPostfix = implode('\\', $stackPostfixEntityInterfaceName);

        $this->interfaceNameToEntityPostfix[$entityInterfaceName] = $entityPostfix;

        return $this->interfaceNameToEntityPostfix[$entityInterfaceName];
    }


    /**
     * Получение постфикса имени сущности, на основе имени интерфейса
     *
     * @param $entityInterfaceName
     *
     * @return string
     *
     * @throws Exception\ErrorBuildEntityPostfixException
     */
    public function getEntityPostfixByInterfaceName($entityInterfaceName)
    {
        if (false === $this->hasEntityPostfixByInterfaceName($entityInterfaceName)) {
            $errMsg = sprintf('Error build entity postfix for %s', $entityInterfaceName);
            throw new Exception\ErrorBuildEntityPostfixException($errMsg);
        }

        return $this->interfaceNameToEntityPostfix[$entityInterfaceName];
    }

    /**
     * @return ObjectManagerAutoDetectorInterface
     */
    public function getObjectManagerAutoDetector()
    {
        return $this->objectManagerAutoDetector;
    }

    /**
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     *
     * @return $this
     */
    public function setObjectManagerAutoDetector($objectManagerAutoDetector)
    {
        $this->objectManagerAutoDetector = $objectManagerAutoDetector;

        return $this;
    }

    /**
     * Возвращает настройки модуля
     *
     * @return ModuleOptionsInterface
     */
    public function getModuleOptions()
    {
        return $this->moduleOptions;
    }

    /**
     * Устанавливает настройки модуля
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

    /**
     * Возвращает утилиту для работы с конфигами модуля DoctrineORMModule
     *
     * @return DoctrineOrmModuleConfigInterface
     */
    public function getDoctrineOrmModuleConfig()
    {
        return $this->doctrineOrmModuleConfig;
    }

    /**
     * Устанавливает утилиту для работы с конфигами модуля DoctrineORMModule
     *
     * @param DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig
     *
     * @return $this
     */
    public function setDoctrineOrmModuleConfig($doctrineOrmModuleConfig)
    {
        $this->doctrineOrmModuleConfig = $doctrineOrmModuleConfig;

        return $this;
    }
}
