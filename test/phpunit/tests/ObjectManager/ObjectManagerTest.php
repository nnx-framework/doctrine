<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\ObjectManager;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManager;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ObjectManagerTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\ObjectManager
 */
class ObjectManagerTest extends AbstractHttpControllerTestCase
{
    /**
     * Проврека получения ObjectManager
     *
     * @return void
     */
    public function testCreateObjectManager()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAbstractFactoryForOrmAppConfig()
        );

        /** @var DoctrineObjectManager $objectManager */
        $objectManager = $this->getApplicationServiceLocator()->get(DoctrineObjectManager::class);

        static::assertInstanceOf(DoctrineObjectManager::class, $objectManager);
    }

    /**
     * Проврека работы абстрактной фабрики, которая создает ObjectManager для DoctrineOrm
     *
     * @return void
     */
    public function testOrmAbstractFactory()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToObjectManagerAbstractFactoryForOrmAppConfig()
        );

        /** @var DoctrineObjectManager $objectManager */
        $objectManager = $this->getApplicationServiceLocator()->get(DoctrineObjectManager::class);

        $testObjectManager = $objectManager->get('doctrine.entitymanager.test');

        static::assertInstanceOf(ObjectManager::class, $testObjectManager);

        $testObjectManagerFromCache = $objectManager->get('doctrine.entitymanager.test');

        $flagValidCache = $testObjectManager === $testObjectManagerFromCache;
        static::assertTrue($flagValidCache);
    }
}
