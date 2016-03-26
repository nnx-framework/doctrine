<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager;

use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;

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
     * ObjectManagerAutoDetector constructor.
     *
     * @param ModuleOptionsPluginManagerInterface $moduleOptionsManager
     */
    public function __construct(ModuleOptionsPluginManagerInterface $moduleOptionsManager)
    {
        $this->setModuleOptionsManager($moduleOptionsManager);
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
        if (false === $this->hasObjectManagerNameByClassName($className)) {
            $errMsg = sprintf('Failed to get the manager\'s name for class %s', $className);
            throw new Exception\ErrorBuildObjectManagerNameException($errMsg);
        }

        return $this->classNameToObjectManagerName[$className];
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
        if (array_key_exists($className, $this->classNameToObjectManagerName)) {
            return false !== $this->classNameToObjectManagerName[$className];
        }

        $moduleOptionsManager =  $this->getModuleOptionsManager();
        if (!$moduleOptionsManager->hasOptionsByClassName($className)) {
            $this->classNameToObjectManagerName[$className] = false;
            return false;
        }

        $moduleOptions = $moduleOptionsManager->getOptionsByClassName($className);

        if (!$moduleOptions instanceof ObjectManagerNameProviderInterface) {
            $this->classNameToObjectManagerName[$className] = false;
            return false;
        }

        $objectManagerName = $moduleOptions->getObjectManagerName();

        if (!is_string($objectManagerName)) {
            $this->classNameToObjectManagerName[$className] = false;
            return false;
        }
        $this->classNameToObjectManagerName[$className] = $objectManagerName;

        return false !== $this->classNameToObjectManagerName[$className];
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
}
