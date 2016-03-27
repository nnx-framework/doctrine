<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Utils;

use Interop\Container\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\Mapping\ClassMetadata;
use Nnx\Doctrine\EntityManager\EntityManagerInterface;
use ReflectionClass;
use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;

/**
 * Class EntityMapBuilder
 *
 * @package Nnx\Doctrine\Utils
 */
class EntityMapBuilder implements EntityMapBuilderInterface
{

    /**
     * Плагин менеджер для получения ObjectManager'ов Doctrine2
     *
     * @var ContainerInterface
     */
    protected $doctrineObjectManager;

    /**
     * Менеджер для работы с настройками модуля
     *
     * @var ModuleOptionsPluginManagerInterface
     */
    protected $moduleOptionsPluginManager;

    /**
     * Менеджер для получения сущностей Doctrine
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * EntityMapBuilder constructor.
     *
     * @param ContainerInterface                  $doctrineObjectManager
     * @param ModuleOptionsPluginManagerInterface $moduleOptionsPluginManager
     * @param EntityManagerInterface              $entityManager
     */
    public function __construct(
        ContainerInterface $doctrineObjectManager,
        ModuleOptionsPluginManagerInterface $moduleOptionsPluginManager,
        EntityManagerInterface $entityManager
    ) {
        $this->setDoctrineObjectManager($doctrineObjectManager);
        $this->setModuleOptionsPluginManager($moduleOptionsPluginManager);
        $this->setEntityManager($entityManager);
    }

    /**
     * @inheritdoc
     *
     * @param $objectManagerName
     *
     * @return array
     *
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function buildEntityMapByObjectManagerName($objectManagerName)
    {
        $entityClassNames = $this->getEntityClassNamesByObjectManagerName($objectManagerName);

        $listEntityInterfaces = $this->buildListEntityInterfaces($entityClassNames);

        $map = [];

        $entityManager = $this->getEntityManager();
        foreach ($listEntityInterfaces as $currentInterface) {
            if ($entityManager->hasEntityClassByInterface($currentInterface)) {
                $map[$currentInterface] = $entityManager->get($currentInterface);
            }
        }

        return $map;
    }

    /**
     * Получает список интерфейсов используемых в сущностях
     *
     * @param array $entityClassNames
     *
     * @return array
     */
    public function buildListEntityInterfaces(array $entityClassNames = [])
    {
        $listEntityInterfaces = [];

        $moduleOptionsManager = $this->getModuleOptionsPluginManager();
        $allowedModules = $this->getAllowedModules($entityClassNames);

        foreach ($entityClassNames as $entityClassName) {
            $r = new ReflectionClass($entityClassName);
            $useInterfaces = $r->getInterfaceNames();
            foreach ($useInterfaces as $currentInterface) {
                if ($moduleOptionsManager->hasModuleNameByClassName($currentInterface)) {
                    $moduleNameByInterface = $moduleOptionsManager->getModuleNameByClassName($currentInterface);
                    if (array_key_exists($moduleNameByInterface, $allowedModules)) {
                        $listEntityInterfaces[$currentInterface] = $currentInterface;
                    }
                }
            }
        }

        return $listEntityInterfaces;
    }

    /**
     * Подготавливает список модулей, в которых могут находиться интерфейсы сущностей
     *
     * @param array $entityClassNames
     *
     * @return array
     */
    public function getAllowedModules(array $entityClassNames = [])
    {
        $moduleOptionsManager = $this->getModuleOptionsPluginManager();
        $allowedModules = [];
        foreach ($entityClassNames as $entityClassName) {
            if ($moduleOptionsManager->hasModuleNameByClassName($entityClassName)) {
                $moduleName = $moduleOptionsManager->getModuleNameByClassName($entityClassName);
                $allowedModules[$moduleName] = $moduleName;
            }
        }

        return  $allowedModules;
    }

    /**
     * Получает список сущностей для ObjectManager'a
     *
     * @param $objectManagerName
     *
     * @return array
     *
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     */
    public function getEntityClassNamesByObjectManagerName($objectManagerName)
    {
        /** @var ObjectManager $objectManager */
        $objectManager = $this->getDoctrineObjectManager()->get($objectManagerName);

        $allMetadata = $objectManager->getMetadataFactory()->getAllMetadata();

        $entityClassNames = [];
        foreach ($allMetadata as $classMetadata) {
            if ($classMetadata instanceof ClassMetadata) {
                $entityClassName = $classMetadata->getName();
                $entityClassNames[$entityClassName] = $entityClassName;
            }
        }

        return $entityClassNames;
    }




    /**
     * Возвращает плагин менеджер для получения ObjectManager'ов Doctrine2
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

    /**
     * Возвращает менеджер для работы с настройками модуля
     *
     * @return ModuleOptionsPluginManagerInterface
     */
    public function getModuleOptionsPluginManager()
    {
        return $this->moduleOptionsPluginManager;
    }

    /**
     * Устанавливает менеджер для работы с настройками модуля
     *
     * @param ModuleOptionsPluginManagerInterface $moduleOptionsPluginManager
     *
     * @return $this
     */
    public function setModuleOptionsPluginManager(ModuleOptionsPluginManagerInterface $moduleOptionsPluginManager)
    {
        $this->moduleOptionsPluginManager = $moduleOptionsPluginManager;

        return $this;
    }

    /**
     * Возвращает менеджер для получения сущностей Doctrine
     *
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Устанавливает менеджер для получения сущностей Doctrine
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
