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
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\RootEntity as RootEntity;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\Overload\RootEntity as OverloadRootEntity;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\AssociatedEntity;

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
     * Описание теста:
     *
     * Создаем три сущности.
     * - rootEntity - Корневая сущность
     * - overloadRootEntity - сущность расширяющая rootEntity
     * - associatedEntity - сущность у которой есть ассоциация с rootEntity
     *
     * У overloadRootEntity, через анотацию \Nnx\Doctrine\Annotation\DiscriminatorEntry указывается значение discriminatorValue,
     * которое должно расширит discriminatorMap rootEntity.
     *
     * При создание associatedEntity, ей устанавливается overloadRootEntity.
     *
     * Еще раз запускается приложение, что бы сбросить все возможные кеши.
     *
     * Из базы читается associatedEntity, првоеряется что сущность реализует корректный класс.
     * Проверяется что при извлечение из базы, сущность associatedEntity связана именно с overloadRootEntity
     *
     *
     *
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

        $rootEntity = new RootEntity();
        $overloadRootEntity = new OverloadRootEntity();
        $overloadRootEntity->setTestValue('test_value');
        $associatedEntity = new AssociatedEntity();
        $associatedEntity->setAssociated($overloadRootEntity);

        $em->persist($rootEntity);
        $em->persist($overloadRootEntity);
        $em->persist($associatedEntity);

        $em->flush();

        $this->reset();

        /** @var DoctrineObjectManagerInterface $doctrineObjectManager */
        $doctrineObjectManager = $this->getApplicationServiceLocator()->get(DoctrineObjectManagerInterface::class);
        $em = $doctrineObjectManager->get('doctrine.entitymanager.test');
        /** @var AssociatedEntity $actualAssociatedEntity */
        $actualAssociatedEntity = $em->getRepository(AssociatedEntity::class)->find($associatedEntity->getId());
        static::assertInstanceOf(AssociatedEntity::class, $actualAssociatedEntity);
        static::assertInstanceOf(OverloadRootEntity::class, $actualAssociatedEntity->getAssociated());
    }
}
