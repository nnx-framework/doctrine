<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\Controller;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use Nnx\Doctrine\Utils\EntityMapCacheInterface;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule1\Entity\TestEntity\TestEntityInterface as TestEntity1Interface;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule2\Entity\TestEntity\TestEntityInterface as TestEntity2Interface;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule3\Entity\TestEntity\TestEntityInterface as TestEntity3Interface;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule2\Entity\TestEntity\TestEntity as TestEntity2;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule3\Entity\TestEntity\TestEntity as TestEntity3;

/**
 * Class EntityMapBuilderController
 *
 * @package Nnx\Doctrine\PhpUnit\Test\Controller
 */
class EntityMapBuilderControllerTest extends AbstractConsoleControllerTestCase
{
    /**
     * Тестирование генерация карты сущностей и сохранение ее в кеше
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Exception
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testBuildAction()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityMapBuilderAppConfig()
        );

        $objectManager = 'doctrine.entitymanager.test';

        /** @var EntityMapCacheInterface $entityMapCache */
        $entityMapCache = $this->getApplication()->getServiceManager()->get(EntityMapCacheInterface::class);
        $entityMapCache->deleteEntityMap($objectManager);

        $this->dispatch("entity-map build --objectManager={$objectManager}");

        $actualEntityMap = $entityMapCache->loadEntityMap($objectManager);

        $expectedEntityMap = [
            TestEntity3Interface::class => TestEntity3::class,
            TestEntity1Interface::class => TestEntity3::class,
            TestEntity2Interface::class => TestEntity2::class,
        ];

        static::assertEquals($expectedEntityMap, $actualEntityMap);
    }

    /**
     * Тестирование сброса кеша карты сущностей
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Exception
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testClearAction()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityMapBuilderAppConfig()
        );

        $objectManager = 'doctrine.entitymanager.test';

        /** @var EntityMapCacheInterface $entityMapCache */
        $entityMapCache = $this->getApplication()->getServiceManager()->get(EntityMapCacheInterface::class);
        $entityMapCache->deleteEntityMap($objectManager);

        $this->dispatch("entity-map build --objectManager={$objectManager}");

        static::assertTrue($entityMapCache->hasEntityMap($objectManager));

        $this->dispatch("entity-map clear --objectManager={$objectManager}");

        static::assertFalse($entityMapCache->hasEntityMap($objectManager));
        $this->assertConsoleOutputContains('Entity map clear');
    }




    /**
     * Тестирование генерация карты сущностей и сохранение ее в кеше. Проверка случая, когда некорректно задано имя
     * ObjectManager
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Exception
     */
    public function testBuildActionInvalidObjectManagerName()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityMapBuilderAppConfig()
        );


        $this->dispatch('entity-map build --objectManager=invalidObjectManagerName');

        $this->assertConsoleOutputContains('Doctrine ObjectManager invalidObjectManagerName not found');
    }
}
