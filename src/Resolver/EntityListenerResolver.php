<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Doctrine\Resolver;

use Doctrine\ORM\Mapping\DefaultEntityListenerResolver;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EntityListenerResolver
 *
 * @package Nnx\Doctrine\Resolver
 */
class EntityListenerResolver extends DefaultEntityListenerResolver
{

    /**
     * @var ServiceLocatorInterface
     */
    private $container;

    /**
     * EntityListenerResolver constructor.
     *
     * @param ServiceLocatorInterface $container
     */
    public function __construct(ServiceLocatorInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function resolve($className)
    {
        if ($this->getContainer()->has($className)) {
            $object = $this->getContainer()->get($className);
            $this->register($object);
        }
        return parent::resolve($className);
    }

    /**
     * @return ServiceLocatorInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }

}