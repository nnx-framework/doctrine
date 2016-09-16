<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Doctrine\Resolver;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class EntityListenerResolverFactory
 *
 * @package Nnx\Doctrine\Resolver
 */
class EntityListenerResolverFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return EntityListenerResolver
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new EntityListenerResolver($serviceLocator);
    }

}