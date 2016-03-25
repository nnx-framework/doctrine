<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\EntityManager;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\EntityManager\EntityManager;
use Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\TestEntity\TestEntityInterface;

/**
 * Class EntityManagerTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\EntityManager
 */
class EntityManagerTest extends AbstractHttpControllerTestCase
{
    /**
     * Проврека получения ObjectManager
     *
     * @return void
     */
    public function testCreateEntityManager()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );

        /** @var EntityManager $entityManager */
        $entityManager = $this->getApplicationServiceLocator()->get(EntityManager::class);

        static::assertInstanceOf(EntityManager::class, $entityManager);
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
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );

        /** @var EntityManager $entityManager */
        $entityManager = $this->getApplicationServiceLocator()->get(EntityManager::class);

        $entityManager->get(TestEntityInterface::class);
    }
}
