<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Zend\ServiceManager\AbstractPluginManager;
use Zend\ServiceManager\ConfigInterface;


/**
 * Class EntityManager
 *
 * @package Nnx\Doctrine\EntityManager
 */
class EntityManager extends AbstractPluginManager implements EntityManagerInterface
{
    /**
     * Имя секции в конфиге приложения отвечающей за настройки менеджера
     *
     * @var string
     */
    const CONFIG_KEY = 'nnx_entity_manager';

    /**
     * Кеш связывающий имя интерфейса и имя класса сущности
     *
     * @var array
     */
    protected $interfaceNameToEntityClass = [];

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

    /**
     * @inheritdoc
     *
     * @param $interfaceName
     *
     * @return string
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Zend\ServiceManager\Exception\ServiceNotCreatedException
     * @throws \Zend\ServiceManager\Exception\RuntimeException
     * @throws Exception\ErrorBuildEntityClassNameException
     */
    public function getEntityClassByInterface($interfaceName)
    {
        if ($this->hasEntityClassByInterface($interfaceName)) {
            $errMsg = sprintf('Error build entity class name for %s', $interfaceName) ;
            throw new Exception\ErrorBuildEntityClassNameException($errMsg);
        }

        return $this->interfaceNameToEntityClass[$interfaceName];
    }

    /**
     * @inheritdoc
     *
     * @param $interfaceName
     *
     * @return boolean
     *
     * @throws \Zend\ServiceManager\Exception\ServiceNotFoundException
     * @throws \Zend\ServiceManager\Exception\ServiceNotCreatedException
     * @throws \Zend\ServiceManager\Exception\RuntimeException
     */
    public function hasEntityClassByInterface($interfaceName)
    {
        if (array_key_exists($interfaceName, $this->interfaceNameToEntityClass)) {
            return false !== $this->interfaceNameToEntityClass[$interfaceName];
        }

        if (!$this->has($interfaceName)) {
            $this->interfaceNameToEntityClass[$interfaceName] = false;
            return false;
        }

        $entity = $this->get($interfaceName);

        if (!is_object($entity)) {
            $this->interfaceNameToEntityClass[$interfaceName] = false;
            return false;
        }

        $this->interfaceNameToEntityClass[$interfaceName] = get_class($entity);

        return true;
    }
}
