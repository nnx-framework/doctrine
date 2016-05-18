<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;


use Nnx\Doctrine\ManagerRegistry\ParamsFromDoctrineModuleListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\DependencyIndicatorInterface;
use Zend\ModuleManager\Listener\ServiceListenerInterface;
use Zend\ModuleManager\ModuleManager;
use Zend\ModuleManager\ModuleManagerInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\InitProviderInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManager;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManagerProviderInterface;
use Nnx\Doctrine\EntityManager\EntityManager;
use Nnx\Doctrine\EntityManager\EntityManagerProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;
use Zend\Console\Adapter\AdapterInterface as Console;
use Nnx\Doctrine\ManagerRegistry\ResolverManagerRegistryResourceListener;
use Nnx\Doctrine\Listener\ManagerRegistryListener;
use Nnx\ModuleOptions\Module as ModuleOptions;

/**
 * Class Module
 *
 * @package Nnx\ModuleOptions
 */
class Module implements
    BootstrapListenerInterface,
    AutoloaderProviderInterface,
    InitProviderInterface,
    ConfigProviderInterface,
    ConsoleUsageProviderInterface,
    ConsoleBannerProviderInterface,
    DependencyIndicatorInterface
{
    /**
     * Имя секции в конфиги приложения отвечающей за настройки модуля
     *
     * @var string
     */
    const CONFIG_KEY = 'nnx_doctrine';

    /**
     * Имя модуля
     *
     * @var string
     */
    const MODULE_NAME = __NAMESPACE__;

    /**
     * @return array
     */
    public function getModuleDependencies()
    {
        return [
            ModuleOptions::MODULE_NAME
        ];
    }


    /**
     * @param ModuleManagerInterface $manager
     *
     * @throws Exception\InvalidArgumentException
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function init(ModuleManagerInterface $manager)
    {
        if (!$manager instanceof ModuleManager) {
            $errMsg = sprintf('Module manager not implement %s', ModuleManager::class);
            throw new Exception\InvalidArgumentException($errMsg);
        }

        /** @var ServiceLocatorInterface $sm */
        $sm = $manager->getEvent()->getParam('ServiceManager');

        if (!$sm instanceof ServiceLocatorInterface) {
            $errMsg = sprintf('Service locator not implement %s', ServiceLocatorInterface::class);
            throw new Exception\InvalidArgumentException($errMsg);
        }
        /** @var ServiceListenerInterface $serviceListener */
        $serviceListener = $sm->get('ServiceListener');
        if (!$serviceListener instanceof ServiceListenerInterface) {
            $errMsg = sprintf('ServiceListener not implement %s', ServiceListenerInterface::class);
            throw new Exception\InvalidArgumentException($errMsg);
        }

        $serviceListener->addServiceManager(
            DoctrineObjectManager::class,
            DoctrineObjectManager::CONFIG_KEY,
            DoctrineObjectManagerProviderInterface::class,
            'getDoctrineObjectManagerConfig'
        );

        $serviceListener->addServiceManager(
            EntityManager::class,
            EntityManager::CONFIG_KEY,
            EntityManagerProviderInterface::class,
            'getEntityManagerConfig'
        );
    }

    /**
     * @inheritdoc
     *
     * @param EventInterface $e
     *
     * @return array|void
     * @throws \Nnx\Doctrine\Exception\InvalidArgumentException
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     */
    public function onBootstrap(EventInterface $e)
    {
        if (!$e instanceof MvcEvent) {
            $errMsg = sprintf('Event not implement %s', MvcEvent::class);
            throw new Exception\InvalidArgumentException($errMsg);
        }

        $app = $e->getApplication();

        $eventManager        = $app->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $sl = $app->getServiceManager();
        /** @var ParamsFromDoctrineModuleListener $paramsFromDoctrineModuleListener */
        $paramsFromDoctrineModuleListener = $sl->get(ParamsFromDoctrineModuleListener::class);
        $paramsFromDoctrineModuleListener->attach($eventManager);


        /** @var ResolverManagerRegistryResourceListener $resolverManagerRegistryResourceListener */
        $resolverManagerRegistryResourceListener = $sl->get(ResolverManagerRegistryResourceListener::class);
        $resolverManagerRegistryResourceListener->attach($eventManager);

        /** @var ManagerRegistryListener $managerRegistryListener */
        $managerRegistryListener = $sl->get(ManagerRegistryListener::class);
        $managerRegistryListener->attach($eventManager);

    }



    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/',
                ),
            ),
        );
    }


    /**
     * @return mixed
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * @inheritdoc
     *
     * @param Console $console
     *
     * @return string
     */
    public function getConsoleBanner(Console $console){
        return 'Tools for entity map';
    }

    /**
     * @inheritdoc
     *
     * @param Console $console
     *
     * @return array
     */
    public function getConsoleUsage(Console $console){
        return [
            'Entity map builder',
            'entity-map build --objectManager=' => 'Generation entity maps and cached',
            ['--objectManager=MANAGER_NAME', 'ObjectManager name'],
            'entity-map clear --objectManager=' => 'Clear entity maps from cached',
            ['--objectManager=MANAGER_NAME', 'ObjectManager name'],
        ];
    }
} 