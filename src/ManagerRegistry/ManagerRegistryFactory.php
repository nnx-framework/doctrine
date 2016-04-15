<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry;

use Nnx\ModuleOptions\ModuleOptionsPluginManagerInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\ArrayUtils;
use Nnx\Doctrine\Options\ModuleOptionsInterface;


/**
 * Class ManagerRegistry
 *
 * @package Nnx\Doctrine\ManagerRegistry
 */
class ManagerRegistryFactory implements FactoryInterface
{
    use EventManagerAwareTrait;

    /**
     * Имя события бросаемое когда необходимо получить список используемых соеденений
     *
     * @var string
     */
    const EVENT_BUILD_LIST_CONNECTIONS = 'managerRegistryFactory.buildListConnections';

    /**
     * Имя события бросаемое когда необходимо получить список используемых соеденений
     *
     * @var string
     */
    const EVENT_BUILD_LIST_OBJECT_MANAGERS = 'managerRegistryFactory.buildListObjectManagers';

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
        /** @var ModuleOptionsPluginManagerInterface $moduleOptionsPluginManager */
        $moduleOptionsPluginManager = $serviceLocator->get(ModuleOptionsPluginManagerInterface::class);
        /** @var ModuleOptionsInterface $moduleOptions */
        $moduleOptions = $moduleOptionsPluginManager->get(ModuleOptionsInterface::class);

        $managerRegistryOptions = $moduleOptions->getManagerRegistry();


        $buildListConnectionsResult = $this->getEventManager()->trigger(static::EVENT_BUILD_LIST_CONNECTIONS, $this);
        $listConnectionsResult = [];
        foreach ($buildListConnectionsResult as $item) {
            if (is_array($item)) {
                $listConnectionsResult = ArrayUtils::merge($listConnectionsResult, $item);
            }
        }
        $listConnectionsResult = ArrayUtils::merge($listConnectionsResult, $managerRegistryOptions->getConnections());


        $buildListObjectManagersResult = $this->getEventManager()->trigger(static::EVENT_BUILD_LIST_OBJECT_MANAGERS, $this);
        $listObjectManagersResult = [];
        foreach ($buildListObjectManagersResult as $item) {
            if (is_array($item)) {
                $listObjectManagersResult = ArrayUtils::merge($listObjectManagersResult, $item);
            }
        }
        $listObjectManagersResult = ArrayUtils::merge($listObjectManagersResult, $managerRegistryOptions->getObjectManagers());

        return new ManagerRegistry(
            ManagerRegistry::NAME,
            $listConnectionsResult,
            $listObjectManagersResult,
            $managerRegistryOptions->getDefaultConnection(),
            $managerRegistryOptions->getDefaultManager(),
            $managerRegistryOptions->getProxyInterfaceName()
        );
    }
}
