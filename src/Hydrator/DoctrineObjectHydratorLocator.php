<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Hydrator;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject;
use Doctrine\Common\Persistence\ObjectManager;
use ReflectionClass;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;
use Nnx\Doctrine\ObjectManager\DoctrineObjectManagerInterface;


/**
 * Class DoctrineObjectHydratorLocator
 *
 * @package Nnx\Doctrine\Hydrator
 */
class DoctrineObjectHydratorLocator implements DoctrineObjectHydratorLocatorInterface
{
    /**
     * Кеши - ключем является имя класса гидратора,  значением объект прототип, либо false
     *
     * @var array
     */
    protected $prototype = [];

    /**
     * Кеш ключем которого является имя класса гидратора, а значением true/false. Т.е. является ли класс корректным потомком
     * \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     *
     * @var array
     */
    protected $validDoctrineObjectHydratorClass = [];

    /**
     * Сервис позволяющий получить ObjectManager по имени класса
     *
     * @var ObjectManagerAutoDetectorInterface
     */
    protected $objectManagerAutoDetector;

    /**
     * Плагин менеджер для получения ObjectManager'ов доктрины
     *
     * @var DoctrineObjectManagerInterface
     */
    protected $doctrineObjectManager;

    /**
     * Ключем является имя класса,  а значением объект рефлексии для него
     *
     * @var array
     */
    protected $reflectionClassCache = [];

    /**
     * DoctrineObjectHydratorLocator constructor.
     *
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     * @param DoctrineObjectManagerInterface     $doctrineObjectManager
     */
    public function __construct(ObjectManagerAutoDetectorInterface $objectManagerAutoDetector, DoctrineObjectManagerInterface $doctrineObjectManager)
    {
        $this->setObjectManagerAutoDetector($objectManagerAutoDetector);
        $this->setDoctrineObjectManager($doctrineObjectManager);
    }

    /**
     * @param string $id
     *
     * @return DoctrineObject
     *
     * @throws Exception\NotFoundDoctrineObjectHydratorException
     */
    public function get($id)
    {
        if (false === $this->has($id)) {
            $errMsg = sprintf('Invalid create %s', $id);
            throw new Exception\NotFoundDoctrineObjectHydratorException($errMsg);
        }

        return clone $this->prototype[$id];
    }

    /**
     * @inheritdoc
     *
     * @param string $id
     *
     * @return bool
     */
    public function has($id)
    {
        if (array_key_exists($id, $this->prototype)) {
            return false !== $this->prototype[$id];
        }

        $this->prototype[$id] = $this->buildDoctrineObjectHydratorPrototype($id);

        return false !== $this->prototype[$id];
    }

    /**
     * Созддает объект прототип по имени гидратора
     *
     * @param $hydratorName
     *
     * @return DoctrineObject|false
     */
    protected function buildDoctrineObjectHydratorPrototype($hydratorName)
    {
        if (!class_exists($hydratorName)) {
            $this->prototype[$hydratorName] = false;
            return false;
        }

        if (!$this->isValidDoctrineObjectHydratorClass($hydratorName)) {
            $this->prototype[$hydratorName] = false;
            return false;
        }

        $objectManagerAutoDetector = $this->getObjectManagerAutoDetector();
        if (false === $objectManagerAutoDetector->hasObjectManagerNameByClassName($hydratorName)) {
            $this->prototype[$hydratorName] = false;
            return false;
        }

        $objectManagerName = $objectManagerAutoDetector->getObjectManagerNameByClassName($hydratorName);

        $doctrineObjectManager = $this->getDoctrineObjectManager();

        if (false === $doctrineObjectManager->has($objectManagerName)) {
            $this->prototype[$hydratorName] = false;
            return false;
        }

        /** @var ObjectManager $objectManager */
        $objectManager = $doctrineObjectManager->get($objectManagerName);

        $r = array_key_exists($hydratorName, $this->reflectionClassCache) ? $this->reflectionClassCache[$hydratorName] : new ReflectionClass($hydratorName);

        $this->prototype[$hydratorName] = $r->newInstance($objectManager);


        return $this->prototype[$hydratorName];
    }

    /**
     * Проверка является ли класс корректным потомком \DoctrineModule\Stdlib\Hydrator\DoctrineObject
     *
     * @param $hydratorClass
     *
     * @return bool
     */
    public function isValidDoctrineObjectHydratorClass($hydratorClass)
    {
        if (array_key_exists($hydratorClass, $this->validDoctrineObjectHydratorClass)) {
            return $this->validDoctrineObjectHydratorClass[$hydratorClass];
        }

        $r = array_key_exists($hydratorClass, $this->reflectionClassCache) ? $this->reflectionClassCache[$hydratorClass] : new ReflectionClass($hydratorClass);

        if (!$r->isInstantiable()) {
            $this->validDoctrineObjectHydratorClass[$hydratorClass] = false;
            return false;
        }

        if (!$r->isSubclassOf(DoctrineObject::class)) {
            $this->validDoctrineObjectHydratorClass[$hydratorClass] = false;
            return false;
        }

        $rConstructorParams = $r->getConstructor()->getParameters();

        $isConstructorParamValid = true;
        foreach ($rConstructorParams as $rParam) {
            if (0 === $rParam->getPosition()) {
                $rArgClass = $rParam->getClass();
                if (null !== $rArgClass && ObjectManager::class !== $rArgClass->getName()) {
                    $isConstructorParamValid = false;
                    break;
                }
                continue;
            }

            if (!$rParam->isOptional()) {
                $isConstructorParamValid = false;
                break;
            }
        }


        $this->validDoctrineObjectHydratorClass[$hydratorClass] = $isConstructorParamValid;

        return true;
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
     * Возвращает плагин менеджер для получения ObjectManager'ов доктрины
     *
     * @return DoctrineObjectManagerInterface
     */
    public function getDoctrineObjectManager()
    {
        return $this->doctrineObjectManager;
    }

    /**
     * Устанавливает плагин менеджер для получения ObjectManager'ов доктрины
     *
     * @param DoctrineObjectManagerInterface $doctrineObjectManager
     *
     * @return $this
     */
    public function setDoctrineObjectManager($doctrineObjectManager)
    {
        $this->doctrineObjectManager = $doctrineObjectManager;

        return $this;
    }
}
