<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\DiscriminatorEntry;

use Doctrine\ORM\Tools\SchemaTool;
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\TestEntity as TestEntity1;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\NS\TestEntity as TestEntity2;


/**
 * Class DiscriminatorEntryFunctionalTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\DiscriminatorEntry
 */
class DiscriminatorEntryFunctionalTest extends AbstractConsoleControllerTestCase
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
            include TestPaths::getPathToDiscriminatorEntryAppConfig()
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
     * Проверка возможности заполнять discriminatorMap корневой сущности, через анотации сущностей потомков
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Exception
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testDiscriminatorEntry()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToDiscriminatorEntryAppConfig()
        );

        /** @var DoctrineObjectManagerInterface $doctrineObjectManager */
        $doctrineObjectManager = $this->getApplicationServiceLocator()->get(DoctrineObjectManagerInterface::class);

        $em = $doctrineObjectManager->get('doctrine.entitymanager.test');

        $e1 = new TestEntity1();
        $e2 = new TestEntity2();

        $em->persist($e1);
        $em->persist($e2);

        $em->flush();
        $em->clear();

        $actualE2 = $em->getRepository(TestEntity1::class)->find($e2->getId());

        static::assertInstanceOf(TestEntity2::class, $actualE2);
    }
}
