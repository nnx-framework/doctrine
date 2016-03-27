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
        $entityMapCache->deleteEntityMap($objectManager);

        $this->dispatch("entity-map build --objectManager={$objectManager}");

        /** @var EntityManagerInterface $entityManager */
        $entityManager = $appServiceManager->get(EntityManagerInterface::class);

        $entity = $entityManager->get(TestEntityInterface::class);

        static::assertInstanceOf(TestEntity::class, $entity);
    }
}
