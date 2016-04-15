<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\Utils\DoctrineOrmModuleConfigInterface;


/**
 * Class ParamsFromDoctrineModuleListenerFactory
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ParamsFromDoctrineModuleListenerFactory implements FactoryInterface
{
    /**
     * @inheritdoc
     *
     * @param ServiceLocatorInterface $serviceLocator
     *
     * @return mixed
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {

        /** @var DoctrineOrmModuleConfigInterface $doctrineOrmModuleConfig */
        $doctrineOrmModuleConfig = $serviceLocator->get(DoctrineOrmModuleConfigInterface::class);

        return new ParamsFromDoctrineModuleListener($doctrineOrmModuleConfig);
    }
}
