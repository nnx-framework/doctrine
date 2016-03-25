<?php
/**
 * @link    https://github.com/nnx-company/doctrine
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
     * @throws Exception\RuntimeException
     */
    public function getObjectManagerNameByClassName($className)
    {
        $moduleOptions = $this->getModuleOptionsManager()->getOptionsByClassName($className);

        if (!$moduleOptions instanceof ObjectManagerNameProviderInterface) {
            $errMsg = sprintf('Module options not implement %s', ObjectManagerNameProviderInterface::class);
            throw new Exception\RuntimeException($errMsg);
        }

        $objectManagerName = $moduleOptions->getObjectManagerName();

        if (!is_string($objectManagerName)) {
            $errMsg = 'Invalid object manager name. Manager name not string';
            throw new Exception\RuntimeException($errMsg);
        }

        return $objectManagerName;
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
