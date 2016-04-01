<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\EntityManager;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\Doctrine\Utils\EntityMapCacheInterface;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use Nnx\Doctrine\EntityManager\EntityManagerInterface;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule1\Entity\TestEntity\TestEntityInterface;
use Nnx\Doctrine\PhpUnit\TestData\EntityMapBuilder\TestModule3\Entity\TestEntity\TestEntity;



/**
 * Class EntityMapAbstractFactoryFunctionalTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\EntityManager
 */
class EntityMapAbstractFactoryFunctionalTest extends AbstractConsoleControllerTestCase
{
    /**
     * Проврека получения ObjectManager
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Exception
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testCreateEntityManager()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityMapBuilderAppConfig()
        );

        $objectManager = 'doctrine.entitymanager.test';

        $appServiceManager = $this->getApplication()->getServiceManager();

        /** @var EntityMapCacheInterface $entityMapCache */
        $entityMapCache = $appServiceManager->get(EntityMapCacheInterface::class);
        if ($entityMapCache->hasEntityMap($objectManager)) {
            $entityMapCache->deleteEntityMap($objectManager);
        }

        static::assertFalse($entityMapCache->hasEntityMap($objectManager));

        $this->dispatch("entity-map build --objectManager={$objectManager}");

        static::assertTrue($entityMapCache->hasEntityMap($objectManager));

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $appServiceManager->get(EntityManagerInterface::class);

        $entity = $entityManager->get(TestEntityInterface::class);

        static::assertInstanceOf(TestEntity::class, $entity);
    }

    /**
     * Проврека получения ObjectManager
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Exception
     * @throws \Interop\Container\Exception\NotFoundException
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testAutoBuildCache()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityMapBuilderAppConfig()
        );
        $appServiceManager = $this->getApplication()->getServiceManager();

        $objectManager = 'doctrine.entitymanager.test';


        /** @var  EntityMapCacheInterface$entityMapCache */
        $entityMapCache = $appServiceManager->get(EntityMapCacheInterface::class);
        if ($entityMapCache->hasEntityMap($objectManager)) {
            $entityMapCache->deleteEntityMap($objectManager);
        }

        static::assertFalse($entityMapCache->hasEntityMap($objectManager));

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $appServiceManager->get(EntityManagerInterface::class);
        $entity = $entityManager->get(TestEntityInterface::class);

        static::assertInstanceOf(TestEntity::class, $entity);

        static::assertTrue($entityMapCache->hasEntityMap($objectManager));
    }
}
