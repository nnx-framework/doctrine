<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\Service;

use Doctrine\ORM\Tools\SchemaTool;
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\Service\ObjectManagerServiceInterface;
use Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve as TestApp;

/**
 * Class ObjectManagerService
 *
 * @package Nnx\Doctrine\PhpUnit\Test\Service
 */
class ObjectManagerServiceTest extends AbstractHttpControllerTestCase
{

    /**
     * Подготавливаем базу
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Doctrine\ORM\Tools\ToolsException
     */
    protected function setUp()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getApplication()->getServiceManager()->get('doctrine.entitymanager.test');

        $tool = new SchemaTool($em);
        $tool->dropDatabase();

        $metadata = $em->getMetadataFactory()->getAllMetadata();
        $tool->createSchema($metadata);


        parent::setUp();
    }


    /**
     * Проврека получения репозитория по интерфейсу сущности
     *
     * @return void
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetRepositoryByInterface()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );

        /** @var ObjectManagerServiceInterface $objectManagerService */
        $objectManagerService = $this->getApplicationServiceLocator()->get(ObjectManagerServiceInterface::class);

        $testEntityRep = $objectManagerService->getRepository(TestApp\TestModule1\Entity\TestEntity\TestEntityInterface::class);

        static::assertInstanceOf(TestApp\TestModule3\Repository\CustomRepository::class, $testEntityRep);
    }

    /**
     * Проврека получения репозитория по имени класса сущности сущности
     *
     * @return void
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetRepositoryByClassName()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );

        /** @var ObjectManagerServiceInterface $objectManagerService */
        $objectManagerService = $this->getApplicationServiceLocator()->get(ObjectManagerServiceInterface::class);

        $testEntityRep = $objectManagerService->getRepository(TestApp\TestModule1\Entity\TestEntity\TestEntity::class);

        static::assertEquals(TestApp\TestModule1\Entity\TestEntity\TestEntity::class, $testEntityRep->getClassName());
    }


    /**
     * Проврека сохранения сущности
     *
     * @return void
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testSaveEntityObject()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );

        /** @var ObjectManagerServiceInterface $objectManagerService */
        $objectManagerService = $this->getApplicationServiceLocator()->get(ObjectManagerServiceInterface::class);

        /** @var TestApp\TestModule1\Entity\TestEntity\TestEntityInterface $entity */
        $entity = $objectManagerService->createEntityObject(TestApp\TestModule1\Entity\TestEntity\TestEntityInterface::class);

        $objectManagerService->saveEntityObject($entity, true);

        $this->reset();

        /** @var ObjectManagerServiceInterface $objectManagerService */
        $objectManagerService = $this->getApplicationServiceLocator()->get(ObjectManagerServiceInterface::class);

        $objectManagerService->getRepository(TestApp\TestModule1\Entity\TestEntity\TestEntityInterface::class)->find($entity->getId());
    }


    /**
     * Проврека создания сущности
     *
     * @return void
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testCreateEntityObject()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );

        /** @var ObjectManagerServiceInterface $objectManagerService */
        $objectManagerService = $this->getApplicationServiceLocator()->get(ObjectManagerServiceInterface::class);

        /** @var TestApp\TestModule1\Entity\TestEntity\TestEntityInterface $entity */
        $entity = $objectManagerService->createEntityObject(TestApp\TestModule1\Entity\TestEntity\TestEntityInterface::class);

        static::assertInstanceOf(TestApp\TestModule3\Entity\TestEntity\TestEntity::class, $entity);
    }
}
