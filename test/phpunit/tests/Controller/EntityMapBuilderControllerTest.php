<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\Test\Controller;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;
use Zend\Test\PHPUnit\Controller\AbstractConsoleControllerTestCase;

/**
 * Class EntityMapBuilderController
 *
 * @package Nnx\Doctrine\PhpUnit\Test\Controller
 */
class EntityMapBuilderControllerTest extends AbstractConsoleControllerTestCase
{
    /**
     * Тестирование генерация карты сущностей и сохранение ее в кеше
     *
     * @return void
     */
    public function testBuildAction()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );

        $this->dispatch('entity-map build --objectManager=test');
    }

    /**
     * Тестирование генерация карты сущностей и сохранение ее в кеше. Проверка случая, когда некорректно задано имя
     * ObjectManager
     *
     * @return void
     */
    public function testBuildActionInvalidObjectManagerName()
    {

        /** @noinspection PhpIncludeInspection */
        $this->setApplicationConfig(
            include TestPaths::getPathToEntityAutoResolveAppConfig()
        );


        $this->dispatch('entity-map build --objectManager=invalidObjectManagerName');

        $this->assertConsoleOutputContains('Doctrine ObjectManager invalidObjectManagerName not found');
    }
}
