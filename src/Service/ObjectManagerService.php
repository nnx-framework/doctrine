<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Service;

use Doctrine\Common\Persistence\ObjectRepository;
use Nnx\Doctrine\EntityManager\EntityManagerInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Doctrine\Common\Util\ClassUtils;

/**
 * Class ObjectManagerService
 *
 * @package Nnx\Doctrine\Service
 */
class ObjectManagerService implements ObjectManagerServiceInterface
{

    /**
     * Сервис позволяющий получить ObjectManager по имени класса
     *
     * @var ObjectManagerAutoDetectorInterface
     */
    protected $objectManagerAutoDetector;

    /**
     * Менеджер для создания сущностей по интерфейсу
     *
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * ObjectManagerService constructor.
     *
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     * @param EntityManagerInterface             $entityManager
     */
    public function __construct(ObjectManagerAutoDetectorInterface $objectManagerAutoDetector, EntityManagerInterface $entityManager)
    {
        $this->setObjectManagerAutoDetector($objectManagerAutoDetector);
        $this->setEntityManager($entityManager);
    }

    /**
     * @inheritdoc
     *
     * @param $entityName
     *
     * @return ObjectRepository
     */
    public function getRepository($entityName)
    {
        $resolvedEntityName = $this->getEntityManager()->getEntityClassByInterface($entityName);
        $objectManager = $this->getObjectManagerAutoDetector()->getObjectManagerByClassName($resolvedEntityName);
        return $objectManager->getRepository($resolvedEntityName);
    }

    /**
     * @inheritdoc
     *
     * @param mixed $entityObject
     *
     * @throws Exception\InvalidEntityObjectException
     */
    public function saveEntityObject($entityObject, $flagFlush = self::FLAG_PERSIST)
    {
        if (!is_object($entityObject)) {
            $errMsg = sprintf('Entity type %s is invalid.', gettype($entityObject));
            throw new Exception\InvalidEntityObjectException($errMsg);
        }

        $className = ClassUtils::getClass($entityObject);
        $objectManager = $this->getObjectManagerAutoDetector()->getObjectManagerByClassName($className);

        $objectManager->persist($entityObject);
        if ($flagFlush) {
            /** @noinspection PhpMethodParametersCountMismatchInspection */
            //@TODO На уровне интерфейса ObjectManager'a возможности передать сущность в flush нет, есть только в \Doctrine\ORM\EntityManager::flush. Убрать @noinspection, когда наведут порядок в Doctrine
            $objectManager->flush($flagFlush === self::FLAG_FLUSH_ALL ? null : $entityObject);
        }
    }


    /**
     * @inheritdoc
     *
     * @param string $entityName
     *
     * @throws \Interop\Container\Exception\ContainerException
     * @throws \Nnx\Doctrine\Service\Exception\InvalidEntityObjectException
     * @throws \Interop\Container\Exception\NotFoundException
     */
    public function createEntityObject($entityName, array $options = [])
    {
        return $this->getEntityManager()->get($entityName, $options);
    }

    /**
     * Возвращает сервис позволяющий получить ObjectManager по имени класса
     *
     * @return ObjectManagerAutoDetectorInterface
     */
    public function getObjectManagerAutoDetector()
    {
        return $this->objectManagerAutoDetector;
    }

    /**
     * Устанавливает сервис позволяющий получить ObjectManager по имени класса
     *
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     *
     * @return $this
     */
    public function setObjectManagerAutoDetector(ObjectManagerAutoDetectorInterface $objectManagerAutoDetector)
    {
        $this->objectManagerAutoDetector = $objectManagerAutoDetector;

        return $this;
    }

    /**
     * Возвращает менеджер для создания сущностей по интерфейсу
     *
     * @return EntityManagerInterface
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * Устанавливает менеджер для создания сущностей по интерфейсу
     *
     * @param EntityManagerInterface $entityManager
     *
     * @return $this
     */
    public function setEntityManager(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;

        return $this;
    }
}
