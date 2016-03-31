<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\ObjectManager;

use Doctrine\Common\Persistence\ObjectManager;
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector as App;

/**
 * Class ObjectManagerAutoDetectorTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\ObjectManager
 */
class ObjectManagerAutoDetectorTest extends AbstractHttpControllerTestCase
{
    /**
     * Имя ObjectManager'a испольуземого в тестовом приложение
     *
     * @var string
     */
    const DEFAULT_OBJECT_MANAGER = 'doctrine.entitymanager.test';

    /**
     * Данные для тестирования получения имени ObjectManager используемого в модуле, по имекни класса
     *
     *
     * @return array
     */
    public function dataGetObjectManagerNameByClassName()
    {
        return [
            [App\TestModule1\Entity\TestEntity\TestEntityInterface::class, self::DEFAULT_OBJECT_MANAGER],
            [App\TestModule1\Entity\TestEntity\TestEntity::class, self::DEFAULT_OBJECT_MANAGER],
            [App\TestModule2\Module::class, self::DEFAULT_OBJECT_MANAGER],
            [App\TestModule2\Options\ModuleOptionsFactory::class, self::DEFAULT_OBJECT_MANAGER],
            [App\TestModule3\Entity\TestEntity\TestEntityInterface::class, self::DEFAULT_OBJECT_MANAGER],
            [App\TestModule3\Entity\TestEntity\TestEntity::class, self::DEFAULT_OBJECT_MANAGER],
            [App\TestModule3\Module::class, self::DEFAULT_OBJECT_MANAGER],
            [App\TestModule3\Options\ModuleOptionsFactory::class, self::DEFAULT_OBJECT_MANAGER],
        ];
    }

    /**
     * Данные для тестирования возможности получения имени ObjectManager используемого в модуле, по имекни класса
     *
     *
     * @return array
     */
    public function dataHasObjectManagerNameByClassName()
    {
        return [
            [App\TestModule1\Entity\TestEntity\TestEntityInterface::class, true],
            [App\TestModule1\Entity\TestEntity\TestEntity::class, true],
            [App\TestModule2\Module::class, true],
            [App\TestModule2\Options\ModuleOptionsFactory::class, true],
            [App\TestModule3\Entity\TestEntity\TestEntityInterface::class, true],
            [App\TestModule3\Entity\TestEntity\TestEntity::class, true],
            [App\TestModule3\Module::class, true],
            [App\TestModule3\Options\ModuleOptionsFactory::class, true],
            [App\TestModule4\Options\ModuleOptionsFactory::class, true],
            ['InvalidClassName', false],
            [\stdClass::class, false],
            [\DateTime::class, false],
        ];
    }


    /**
     * Данные для тестирования возможности получения ObjectManager используемого в модуле, по имекни класса
     *
     *
     * @return array
     */
    public function dataHasObjectManagerByClassName()
    {
        return [
            [App\TestModule1\Entity\TestEntity\TestEntityInterface::class, true],
            [App\TestModule1\Entity\TestEntity\TestEntity::class, true],
            [App\TestModule2\Module::class, true],
            [App\TestModule2\Options\ModuleOptionsFactory::class, true],
            [App\TestModule3\Entity\TestEntity\TestEntityInterface::class, true],
            [App\TestModule3\Entity\TestEntity\TestEntity::class, true],
            [App\TestModule3\Module::class, true],
            [App\TestModule3\Options\ModuleOptionsFactory::class, true],
            [App\TestModule4\Options\ModuleOptionsFactory::class, false],
            ['InvalidClassName', false],
            [\stdClass::class, false],
            [\DateTime::class, false],
        ];
    }


    /**
     * Данные для тестирования получения ObjectManager используемого в модуле, по имекни класса
     *
     *
     * @return array
     */
    public function dataGetObjectManagerByClassName()
    {
        return [
            [App\TestModule1\Entity\TestEntity\TestEntityInterface::class, true],
            [App\TestModule1\Entity\TestEntity\TestEntity::class, true],
            [App\TestModule2\Module::class, true],
            [App\TestModule2\Options\ModuleOptionsFactory::class, true],
            [App\TestModule3\Entity\TestEntity\TestEntityInterface::class, true],
            [App\TestModule3\Entity\TestEntity\TestEntity::class, true],
            [App\TestModule3\Module::class, true],
            [App\TestModule3\Options\ModuleOptionsFactory::class, true]
        ];
    }


    /**
     * Данные для тестирования ситуации когда происходит попытка получить ObjectManager по некорректному имени класса,
     * либо когда нет возможности создать нужный ObjectManager
     *
     * @return array
     */
    public function dataGetObjectManagerByClassNameException()
    {
        return [
            [App\TestModule4\Options\ModuleOptionsFactory::class, false],
            ['InvalidClassName', false],
            [\stdClass::class, false],
            [\DateTime::class, false],
        ];
    }

    /**
     * Проврека получения ObjectManagerAutoDetector
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testCreateObjectManagerAutoDetector()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAutoDetectorAppConfig()
        );

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $this->getApplicationServiceLocator()->get(ObjectManagerAutoDetectorInterface::class);
        static::assertInstanceOf(ObjectManagerAutoDetectorInterface::class, $objectManagerAutoDetector);
    }

    /**
     * Проверка получения имени objectManager'a модуля, по имени любого класса принадлежащего данному модулю
     *
     * @dataProvider dataGetObjectManagerNameByClassName
     *
     * @param $className
     * @param $objectManagerName
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetObjectManagerNameByClassName($className, $objectManagerName)
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAutoDetectorAppConfig()
        );

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $this->getApplicationServiceLocator()->get(ObjectManagerAutoDetectorInterface::class);
        static::assertInstanceOf(ObjectManagerAutoDetectorInterface::class, $objectManagerAutoDetector);

        static::assertEquals($objectManagerName, $objectManagerAutoDetector->getObjectManagerNameByClassName($className));
    }

    /**
     * Проверка получения имени objectManager'a модуля, по имени любого класса принадлежащего данному модулю
     *
     * @dataProvider dataHasObjectManagerNameByClassName
     *
     * @param $className
     * @param $expectedResult
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testHasObjectManagerNameByClassName($className, $expectedResult)
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAutoDetectorAppConfig()
        );

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $this->getApplicationServiceLocator()->get(ObjectManagerAutoDetectorInterface::class);
        static::assertInstanceOf(ObjectManagerAutoDetectorInterface::class, $objectManagerAutoDetector);

        static::assertEquals($expectedResult, $objectManagerAutoDetector->hasObjectManagerNameByClassName($className));
    }


    /**
     * Проверка возможности получения objectManager'a модуля, по имени любого класса принадлежащего данному модулю
     *
     * @dataProvider dataHasObjectManagerByClassName
     *
     * @param $className
     * @param $expectedResult
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testHasObjectManagerByClassName($className, $expectedResult)
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAutoDetectorAppConfig()
        );

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $this->getApplicationServiceLocator()->get(ObjectManagerAutoDetectorInterface::class);
        static::assertInstanceOf(ObjectManagerAutoDetectorInterface::class, $objectManagerAutoDetector);

        static::assertEquals($expectedResult, $objectManagerAutoDetector->hasObjectManagerByClassName($className));
    }


    /**
     * Проверка получения objectManager'a модуля, по имени любого класса принадлежащего данному модулю
     *
     * @dataProvider dataGetObjectManagerByClassName
     *
     * @param $className
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetObjectManagerByClassName($className)
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAutoDetectorAppConfig()
        );

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $this->getApplicationServiceLocator()->get(ObjectManagerAutoDetectorInterface::class);
        static::assertInstanceOf(ObjectManagerAutoDetectorInterface::class, $objectManagerAutoDetector);

        static::assertInstanceOf(ObjectManager::class, $objectManagerAutoDetector->getObjectManagerByClassName($className));
    }


    /**
     * Тестирования ситуации когда происходит попытка получить ObjectManager по некорректному имени класса,
     * либо когда нет возможности создать нужный ObjectManager
     *
     * @dataProvider dataGetObjectManagerByClassNameException
     * @expectedException \Nnx\Doctrine\ObjectManager\Exception\ErrorBuildObjectManagerException
     * @expectedExceptionMessageRegExp /Failed to get the manager's name for class (.*)?/
     *
     * @param $className
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetObjectManagerByClassNameException($className)
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAutoDetectorAppConfig()
        );

        /** @var ObjectManagerAutoDetectorInterface $objectManagerAutoDetector */
        $objectManagerAutoDetector = $this->getApplicationServiceLocator()->get(ObjectManagerAutoDetectorInterface::class);
        static::assertInstanceOf(ObjectManagerAutoDetectorInterface::class, $objectManagerAutoDetector);

        $objectManagerAutoDetector->getObjectManagerByClassName($className);
    }
}
