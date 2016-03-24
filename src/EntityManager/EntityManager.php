<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Zend\ServiceManager\AbstractPluginManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ConfigInterface;


/**
 * Class EntityManager
 *
 * @package Nnx\Doctrine\EntityManager
 */
class EntityManager extends AbstractPluginManager implements ContainerInterface
{
    /**
     * Имя секции в конфиге приложения отвечающей за настройки менеджера
     *
     * @var string
     */
    const CONFIG_KEY = 'nnx_entity_manager';

    /**
     * EntityManager constructor.
     *
     * @param ConfigInterface|null $configuration
     * @throws \Zend\ServiceManager\Exception\RuntimeException
     */
    public function __construct(ConfigInterface $configuration = null)
    {
        $this->setShareByDefault(false);
        parent::__construct($configuration);
    }


    /**
     * {@inheritDoc}
     *
     * @throws Exception\RuntimeException
     */
    public function validatePlugin($plugin)
    {
        if (is_object($plugin)) {
            return;
        }

        throw new Exception\RuntimeException(sprintf('Plugin of type %s is invalid', gettype($plugin)));
    }
}
