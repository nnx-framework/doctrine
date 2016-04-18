<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\Listener;

use Zend\EventManager\EventManager;
use Zend\Test\PHPUnit\Controller\AbstractHttpControllerTestCase;
use Nnx\Doctrine\Module;
use Nnx\ModuleOptions\Module as ModuleOptions;
use Nnx\Doctrine\ManagerRegistry\ManagerRegistry;

/**
 * Class ManagerRegistryListenerFunctionalTest
 *
 * @package Nnx\Doctrine\PhpUnit\Test\Listener
 */
class ManagerRegistryListenerFunctionalTest extends AbstractHttpControllerTestCase
{
    /**
     * Проврека получения ManagerRegistry через событие
     *
     * @return void
     * @throws \Zend\EventManager\Exception\InvalidCallbackException
     * @throws \Zend\Stdlib\Exception\LogicException
     *
     */
    public function testGetManagerRegistry()
    {
        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig([
            'module_listener_options' => [],
            'modules' => [
                ModuleOptions::MODULE_NAME,
                Module::MODULE_NAME
            ]
        ]);

        $this->getApplication();

        $eventManager = new EventManager();
        $eventManager->addIdentifiers('DoctrineManagerRegistry');

        $result = $eventManager->trigger('get.doctrineManagerRegistry');

        $managerRegistry = $result->last();

        static::assertInstanceOf(ManagerRegistry::class, $managerRegistry);
    }
}
