<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager;

use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Interop\Container\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Util\ClassUtils;

/**
 * Class ObjectManagerAutoDetector
 *
 * @package Nnx\Doctrine\ObjectManager
 */
class ObjectManagerAutoDetector implements ObjectManagerAutoDetectorInterface
{
    /**
     * Менеджер для работы с настройками модуля
     *
     * @var ModuleOptionsPluginManagerInterface
     */
    protected $moduleOptionsManager;

    /**
     * Кеш, ключем являтся имя класса, а значением имя ObjectManager
     *
     * @var array
     */
    protected $classNameToObjectManagerName = [];

    /**
     * Плагин менеджер для получения ObjectManager'ов Doctrine2
     *
     * @var ContainerInterface
     */
    protected $doctrineObjectManager;

    /**
     * ObjectManagerAutoDetector constructor.
     *
     * @param ModuleOptionsPluginManagerInterface $moduleOptionsManager
     * @param ContainerInterface      $doctrineObjectManager
     */
    public function __construct(
        ModuleOptionsPluginManagerInterface $moduleOptionsManager,
        ContainerInterface $doctrineObjectManager
    ) {
        $this->setModuleOptionsManager($moduleOptionsManager);
        $this->setDoctrineObjectManager($doctrineObjectManager);
    }

    /**
     * Получает имя используемого в модуле ObjectManager'a Doctrine, по имени любого класса модуля
     *
     * @param $className
     *
     * @return string
     *
     * @throws Exception\ErrorBuildObjectManagerNameException
     */
    public function getObjectManagerNameByClassName($className)
    {
        $realClass = ClassUtils::getRealClass($className);
        if (false === $this->hasObjectManagerNameByClassName($realClass)) {
            $errMsg = sprintf('Failed to get the manager\'s name for class %s', $realClass);
            throw new Exception\ErrorBuildObjectManagerNameException($errMsg);
        }

        return $this->classNameToObjectManagerName[$realClass];
    }


    /**
     * Проверяет есть ли возможность по имени класса модуля, получить имя objectManager'a который используется в данном модуле
     *
     * @param $className
     *
     * @return boolean
     *
     */
    public function hasObjectManagerNameByClassName($className)
    {
        $realClass = ClassUtils::getRealClass($className);

        if (array_key_exists($realClass, $this->classNameToObjectManagerName)) {
            return false !== $this->classNameToObjectManagerName[$realClass];
        }

        $moduleOptionsManager =  $this->getModuleOptionsManager();
        if (!$moduleOptionsManager->hasOptionsByClassName($realClass)) {
            $this->classNameToObjectManagerName[$realClass] = false;
            return false;
        }

        $moduleOptions = $moduleOptionsManager->getOptionsByClassName($realClass);

        if (!$moduleOptions instanceof ObjectManagerNameProviderInterface) {
            $this->classNameToObjectManagerName[$realClass] = false;
            return false;
        }

        $objectManagerName = $moduleOptions->getObjectManagerName();

        if (!is_string($objectManagerName)) {
            $this->classNameToObjectManagerName[$realClass] = false;
            return false;
        }
        $this->classNameToObjectManagerName[$realClass] = $objectManagerName;

        return false !== $this->classNameToObjectManagerName[$realClass];
    }


    /**
     * Проверяет есть ли возможность по имени класса модуля, получить objectManager'a который используется в данном модуле
     *
     * @param $className
     *
     * @return boolean
     *
     * @throws Exception\ErrorBuildObjectManagerNameException
     */
    public function hasObjectManagerByClassName($className)
    {
        $realClass = ClassUtils::getRealClass($className);

        if ($this->hasObjectManagerNameByClassName($realClass)) {
            $objectManagerName = $this->getObjectManagerNameByClassName($realClass);
            return $this->getDoctrineObjectManager()->has($objectManagerName);
        }
        return false;
    }

    /**
     * По имени класса модуля, получает objectManager'a который используется в данном модуле
     *
     * @param $className
     *
     * @return ObjectManager
     *
     * @throws Exception\ErrorBuildObjectManagerNameException
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws Exception\ErrorBuildObjectManagerException
     */
    public function getObjectManagerByClassName($className)
    {
        $realClass = ClassUtils::getRealClass($className);

        if (!$this->hasObjectManagerByClassName($realClass)) {
            $errMsg = sprintf('Failed to get the manager\'s name for class %s', $realClass);
            throw new Exception\ErrorBuildObjectManagerException($errMsg);
        }
        $objectManagerName = $this->getObjectManagerNameByClassName($realClass);

        return $this->getDoctrineObjectManager()->get($objectManagerName);
    }



    /**
     * Возвращает менеджер для работы с настройками модуля
     *
     * @return ModuleOptionsPluginManagerInterface
     */
    public function getModuleOptionsManager()
    {
        return $this->moduleOptionsManager;
    }

    /**
     * Устанавливает менеджер для работы с настройками модуля
     *
     * @param ModuleOptionsPluginManagerInterface $moduleOptionsManager
     *
     * @return $this
     */
    public function setModuleOptionsManager(ModuleOptionsPluginManagerInterface $moduleOptionsManager)
    {
        $this->moduleOptionsManager = $moduleOptionsManager;

        return $this;
    }

    /**
     * Возрвщает плагин менеджер для получения ObjectManager'ов Doctrine2
     *
     * @return ContainerInterface
     */
    public function getDoctrineObjectManager()
    {
        return $this->doctrineObjectManager;
    }

    /**
     * Устанавливает плагин менеджер для получения ObjectManager'ов Doctrine2
     *
     * @param ContainerInterface $doctrineObjectManager
     *
     * @return $this
     */
    public function setDoctrineObjectManager(ContainerInterface $doctrineObjectManager)
    {
        $this->doctrineObjectManager = $doctrineObjectManager;

        return $this;
    }
}
