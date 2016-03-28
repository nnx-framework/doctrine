<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\Hydrator;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\PhpUnit\TestData\DoctrineObjectHydrator\TestModule1\Hydrator\TestHydratorChild;

/**
 * Class DoctrineObjectHydratorAbstractFactoryFunctionalTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\Hydrator
 */
class DoctrineObjectHydratorAbstractFactoryFunctionalTest extends AbstractHttpControllerTestCase
{
    /**
     * Проврека получения ObjectManager
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function testGetHydrator()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToDoctrineObjectHydratorAppConfig()
        );

        /** @var ServiceLocatorInterface $hydratorManager */
        $hydratorManager = $this->getApplicationServiceLocator()->get('HydratorManager');

        $hydrator = $hydratorManager->get(TestHydratorChild::class);

        static::assertInstanceOf(TestHydratorChild::class, $hydrator);
    }

    /**
     * Проврека получения ObjectManager
     *
     * @return void
     *
     * @throws \Zend\Stdlib\Exception\LogicException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \PHPUnit_Framework_AssertionFailedError
     */
    public function testHasHydrator()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToDoctrineObjectHydratorAppConfig()
        );

        /** @var ServiceLocatorInterface $hydratorManager */
        $hydratorManager = $this->getApplicationServiceLocator()->get('HydratorManager');

        static::assertTrue($hydratorManager->has(TestHydratorChild::class));
        static::assertFalse($hydratorManager->has('InvalidHydratorName'));
    }
}
