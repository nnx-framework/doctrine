<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @year 2016
 * @author Lobanov Aleksandr <alex912004@gmail.com>
 */

namespace Nnx\Doctrine\Traits\Factory;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\ServiceManager;

/**
 * Class ServiceManagerAwareTrait
 * @package Nnx\Doctrine\Traits\Factory
 */
trait ServiceManagerAwareTrait
{
    /**
     * @var ServiceManager
     */
    private $serviceManager;

    /**
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceManager(ServiceLocatorInterface $serviceLocator)
    {
        /** @var \Zend\ServiceManager\ServiceManager $serviceManager */
        $serviceManager = ($serviceLocator instanceof AbstractPluginManager)
            ? $serviceLocator->getServiceLocator()
            : $serviceLocator;

        $this->serviceManager = $serviceManager;
    }

    /**
     * @return \Zend\ServiceManager\ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }
}
