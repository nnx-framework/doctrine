<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\ManagerRegistry;

use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\Doctrine\ManagerRegistry\ManagerRegistry;
use Doctrine\Common\Persistence\AbstractManagerRegistry;

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
            include TestPaths::getPathToObjectManagerAutoDetectorAppConfig()
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
}
