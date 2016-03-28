<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData;

/**
 * Class TestPaths
 *
 * @package Nnx\Doctrine\PhpUnit\TestData
 */
class TestPaths
{

    /**
     * Путь до директории в которой кешируется данные
     *
     * @return string
     */
    public static function getPathToDoctrineModuleFilesystemCacheDir()
    {
        return __DIR__ . '/../../../data/test/DoctrineModule/cache/';
    }

    /**
     * Возвращает путь путь до директории в которой создаются прокси классы для сущностей доктрины
     *
     * @return string
     */
    public static function getPathToDoctrineProxyDir()
    {
        return __DIR__ . '/../../../data/test/Proxies/';
    }

    /**
     * Путь до директории модуля
     *
     * @return string
     */
    public static function getPathToModule()
    {
        return __DIR__ . '/../../../';
    }

    /**
     * Путь до конфига приложения по умолчанию
     *
     * @return string
     */
    public static function getPathToDefaultAppConfig()
    {
        return  __DIR__ . '/../_files/DefaultApp/application.config.php';
    }

    /**
     * Путь до конфига приложения для тестирования абстрактной фабрики получения ObjectManager доктрины
     *
     * @return string
     */
    public static function getPathToObjectManagerAbstractFactoryForOrmAppConfig()
    {
        return  __DIR__ . '/../_files/ObjectManagerAbstractFactoryForOrm/application.config.php';
    }

    /**
     * Путь до директории в которой расположены модули приложения, используемого для тестирования автоматического
     * определения имени сущности, на основе имени интерфейса
     *
     * @return string
     */
    public static function getPathToEntityAutoResolveAppModuleDir()
    {
        return  __DIR__ . '/../_files/EntityAutoResolve/module/';
    }

    /**
     * Путь до конфига приложения, используемого для тестирования автоматического
     * определения имени сущности, на основе имени интерфейса
     *
     * @return string
     */
    public static function getPathToEntityAutoResolveAppConfig()
    {
        return  __DIR__ . '/../_files/EntityAutoResolve/application.config.php';
    }


    /**
     * Путь до директории в которой расположены модули приложения, используемого для тестирования построения кешя для карты
     * сущностей
     *
     * @return string
     */
    public static function getPathToEntityMapBuilderAppModuleDir()
    {
        return  __DIR__ . '/../_files/EntityMapBuilder/module/';
    }

    /**
     * Путь до директории в которой расположены модули приложения, используемого для тестирования работы абстрактной фабрики
     * для создания DoctrineObjectHydrator
     *
     * @return string
     */
    public static function getPathToDoctrineObjectHydratorAppModuleDir()
    {
        return  __DIR__ . '/../_files/DoctrineObjectHydrator/module/';
    }

    /**
     * Путь до конфига приложения, используемого для тестирования генерации и сохранения карту сущностей
     *
     * @return string
     */
    public static function getPathToEntityMapBuilderAppConfig()
    {
        return  __DIR__ . '/../_files/EntityMapBuilder/application.config.php';
    }


    /**
     * Путь до конфига приложения, используемого для тестирования работы абстрактной фабрики
     * для создания DoctrineObjectHydrator
     *
     * @return string
     */
    public static function getPathToDoctrineObjectHydratorAppConfig()
    {
        return  __DIR__ . '/../_files/DoctrineObjectHydrator/application.config.php';
    }
}
