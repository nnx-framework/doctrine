<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Listener;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class RootEntityListenerFactory
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Listener
 */
class RootEntityListenerFactory implements FactoryInterface
{
    /**
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return RootEntityListener
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new RootEntityListener(true);
    }
}
