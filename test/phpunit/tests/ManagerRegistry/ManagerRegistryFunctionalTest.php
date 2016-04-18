<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\ManagerRegistry;

use Nnx\Doctrine\ManagerRegistry\ManagerRegistryResourceEvent;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\Doctrine\ManagerRegistry\ManagerRegistry;
use Doctrine\Common\Persistence\AbstractManagerRegistry;
use Nnx\Doctrine\PhpUnit\TestData\ManagerRegistry\TestModule1\Entity\RootEntity;


/**
 * Class ManagerRegistryFunctionalTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\ManagerRegistry
 */
class ManagerRegistryFunctionalTest extends AbstractHttpControllerTestCase
{

    /**
     * @inheritdoc
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     */
    public function setUp()
    {        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToManagerRegistryAppConfig()
        );
        parent::setUp();
    }

    /**
     * Проверка получения ManagerRegistry
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testCreateManagerRegistry()
    {
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);

        static::assertInstanceOf(AbstractManagerRegistry::class, $managerRegistry);
    }


    /**
     * Проверка получения имен доступных соеденений
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetConnections()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $actualConnections = $managerRegistry->getConnections();

        $expectedConnections = ['orm_default', 'test'];
        static::assertEquals($expectedConnections, array_keys($actualConnections));
    }

    /**
     * Проверка получения доступных ObjectManager'ов
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetObjectManagers()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $actualObjectManagers = $managerRegistry->getManagers();

        $expectedConnections = ['orm_default', 'test'];
        static::assertEquals($expectedConnections, array_keys($actualObjectManagers));
    }

    /**
     * Данные для тестирования получения соедения к базе данных, по имени соеденения
     *
     */
    public function dataTestGetConnection()
    {
        return [
            ['test', 'Doctrine\DBAL\Connection'],
            ['orm_default', 'Doctrine\DBAL\Connection'],
        ];
    }

    /**
     * Проверка получения соеденения по его имени
     *
     * @dataProvider dataTestGetConnection
     *
     * @param $connectionName
     * @param $expectedClass
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetConnection($connectionName, $expectedClass)
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $connection = $managerRegistry->getConnection($connectionName);

        static::assertInstanceOf($expectedClass, $connection);

        $cachedConnection = $managerRegistry->getConnection($connectionName);

        $validCachedConnection = $connection === $cachedConnection;
        static::assertTrue($validCachedConnection);
    }

    /**
     * Данные для тестирования получения ObjectManager'a по его имени
     *
     */
    public function dataTestGetObjectManager()
    {
        return [
            ['test', 'Doctrine\Common\Persistence\ObjectManager'],
            ['orm_default', 'Doctrine\Common\Persistence\ObjectManager'],
        ];
    }

    /**
     * Проверка получения ObjectManager'a по его имени
     *
     * @dataProvider dataTestGetObjectManager
     *
     * @param $objectManagerName
     * @param $expectedClass
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \InvalidArgumentException
     */
    public function testGetManager($objectManagerName, $expectedClass)
    {

        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $objectManager = $managerRegistry->getManager($objectManagerName);

        static::assertInstanceOf($expectedClass, $objectManager);

        $cachedObjectManager = $managerRegistry->getManager($objectManagerName);

        $validCachedObjectManager = $objectManager === $cachedObjectManager;
        static::assertTrue($validCachedObjectManager);
    }


    /**
     * Проверка ситуация когда происходит ошибка при поптыке получить ObjectManager' по имени
     *
     * @expectedException \Nnx\Doctrine\ManagerRegistry\Exception\ObjectManagerNotFoundException
     * @expectedExceptionMessage Object manager doctrine.entitymanager.test not found
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \InvalidArgumentException
     */
    public function testGetManagerByInvalidName()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $managerRegistry->getEventManager()->attach(ManagerRegistryResourceEvent::RESOLVE_OBJECT_MANAGER_EVENT, function (ManagerRegistryResourceEvent $e) {
            $e->stopPropagation(true);
        });
        $managerRegistry->getManager('test');
    }


    /**
     * Проверка ситуация когда происходит ошибка при поптыке получить соеденение к бд, по его имени
     *
     * @expectedException \Nnx\Doctrine\ManagerRegistry\Exception\ConnectionNotFoundException
     * @expectedExceptionMessage Connection doctrine.connection.test not found
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \InvalidArgumentException
     */
    public function testGetConnectionByInvalidName()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $managerRegistry->getEventManager()->attach(ManagerRegistryResourceEvent::RESOLVE_CONNECTION_EVENT, function (ManagerRegistryResourceEvent $e) {
            $e->stopPropagation(true);
        });
        $managerRegistry->getConnection('test');
    }


    /**
     * Имитация ситуации когда происходит попытка получения соеденения, либо ObjectManager'a, но при этом не задан контекст
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     *
     * @expectedException \Nnx\Doctrine\ManagerRegistry\Exception\RuntimeException
     * @expectedExceptionMessage Invalid execution context
     */
    public function testGetServiceInvalidContext()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $r = new \ReflectionObject($managerRegistry);
        $rMethod = $r->getMethod('getService');
        $rMethod->setAccessible(true);
        $rMethod->invoke($managerRegistry, 'test');
    }


    /**
     * Проверка получения ManagerRegistry
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetManagerForClass()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);

        $objectManager = $managerRegistry->getManagerForClass(RootEntity::class);

        static::assertFalse($objectManager->getMetadataFactory()->isTransient(RootEntity::class));
    }

    /**
     * Проврека сброса ObjectManager'
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testResetManager()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);
        $managerRegistry->resetManager();
    }


    /**
     * Проврека получения namespace сущности по ее псевдониму
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetAliasNamespace()
    {
        /** @var ManagerRegistry $managerRegistry */
        $managerRegistry = $this->getApplicationServiceLocator()->get(ManagerRegistry::class);

        $expected = 'test';
        $actual = $managerRegistry->getAliasNamespace($expected);

        static::assertEquals($expected, $actual);
    }
}
