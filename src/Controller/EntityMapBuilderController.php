<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Controller;

use Zend\Mvc\Controller\AbstractConsoleController;
use Zend\Console\Request;
use Interop\Container\ContainerInterface;
use Zend\View\Model\ConsoleModel;

/**
 * Class EntityMapBuilderController
 *
 * @package Nnx\Doctrine\Controller
 */
class EntityMapBuilderController extends AbstractConsoleController
{
    /**
     * Менеджер для получения ObjectManager Doctrine2
     *
     * @var ContainerInterface
     */
    protected $doctrineObjectManager;

    /**
     * EntityMapBuilderController constructor.
     *
     * @param ContainerInterface $doctrineObjectManager
     */
    public function __construct(ContainerInterface $doctrineObjectManager)
    {
        $this->setDoctrineObjectManager($doctrineObjectManager);
    }


    /**
     * Генерация карты сущностей и сохранение ее в кеше
     *
     */
    public function buildAction()
    {
        /** @var Request $request */
        $request = $this->getRequest();
        $managerName = $request->getParam('objectManager');

        if (!$this->getDoctrineObjectManager()->has($managerName)) {
            return [
                ConsoleModel::RESULT => sprintf('Doctrine ObjectManager %s not found', $managerName)
            ];
        }

        $result = '';


        return [
            ConsoleModel::RESULT => $result
        ];
    }

    /**
     * Возвращает менеджер для получения ObjectManager Doctrine2
     *
     * @return ContainerInterface
     */
    public function getDoctrineObjectManager()
    {
        return $this->doctrineObjectManager;
    }

    /**
     * Устанавливает менеджер для получения ObjectManager Doctrine2
     *
     * @param ContainerInterface $doctrineObjectManager
     *
     * @return $this
     */
    public function setDoctrineObjectManager(ContainerInterface $doctrineObjectManager)
    {
        $this->doctrineObjectManager = $doctrineObjectManager;

        return $this;
    }
}
