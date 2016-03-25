<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\Options\ModuleOptions;
use Nnx\Doctrine\Options\ModuleOptionsInterface;

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
     * OrmEntityLocator constructor.
     *
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     * @param ModuleOptionsInterface             $moduleOptions
     */
    public function __construct(ObjectManagerAutoDetectorInterface $objectManagerAutoDetector, ModuleOptionsInterface $moduleOptions)
    {
        $this->setObjectManagerAutoDetector($objectManagerAutoDetector);
        $this->setModuleOptions($moduleOptions);
    }


    /**
     * @inheritdoc
     *
     * @param string $id
     *
     * @return bool
     */
    public function get($id)
    {
    }

    /**
     * @inheritdoc
     *
     * @param string $id
     *
     * @return mixed
     */
    public function has($id)
    {
        $objectManagerAutoDetector = $this->getObjectManagerAutoDetector();
        if (!$objectManagerAutoDetector->hasObjectManagerNameByClassName($id)) {
            return false;
        }
        $objectManagerName = $objectManagerAutoDetector->getObjectManagerNameByClassName($id);



        return ;
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
}
