<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Doctrine\PhpUnit\Test\Resolver;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Entity\RootEntity;
use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Nnx\Doctrine\Resolver\EntityListenerResolver;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;

/**
 * Class EntityListenerResolver
 *
 * @package Nnx\Doctrine\PhpUnit\Test\Resolver
 */
class EntityListenerResolverTest extends AbstractHttpControllerTestCase
{
    /**
     * @inheritdoc
     */
    protected function setUp()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityListenerResolverAppConfig()
        );

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = $this->getApplication()->getServiceManager()->get('doctrine.entitymanager.test');

        $tool = new SchemaTool($em);
        $tool->dropDatabase();

        $metadata = $em->getMetadataFactory()->getAllMetadata();
        $tool->createSchema($metadata);
    }

    /**
     * @inheritdoc
     */
    public function testGetEntityListenerResolver()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        $resolver = $serviceManager->get(EntityListenerResolver::class);
        static::assertInstanceOf(EntityListenerResolver::class, $resolver);
    }

    /**
     * @inheritdoc
     */
    public function testTriggerEntityListener()
    {
        $serviceManager = $this->getApplicationServiceLocator();
        /** @var EntityManager $objectManager */
        $objectManager = $serviceManager->get('doctrine.entitymanager.test');

        $entity = new RootEntity();

        $objectManager->persist($entity);
        $objectManager->flush($entity);

        static::assertEquals(true, $entity->isListenerChanged());
    }

}