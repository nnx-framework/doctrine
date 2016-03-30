<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\DiscriminatorEntry;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Reader;
use Doctrine\ORM\Events;
use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use ReflectionClass;
use Nnx\Doctrine\Annotation\DiscriminatorEntry;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;


/**
 * Class DiscriminatorEntryListener
 *
 *
 * This Listener listens to the loadClassMetadata event. Upon this event
 * it hooks into Doctrine to update discriminator maps. Adding entries
 * to the discriminator map at parent level is just not nice. We turn this
 * around with this mechanism. In the subclass you will be able to give an
 * entry for the discriminator map. In this listener we will retrieve the
 * load metadata event to update the parent with a good discriminator map,
 * collecting all entries from the subclasses.
 *
 * @see https://gist.github.com/jasperkuperus/03302fefe6e4722ab650
 */
class DiscriminatorEntryListener implements EventSubscriber
{
    /**
     * Сервис для чтения метаданных
     *
     * @var Reader
     */
    protected $reader;

    /**
     * Ключем является хеш ObjectManager'a, а значением список всех классов сущностей
     *
     * @var array
     */
    protected $entityManagerAllClassNames = [];

    /**
     * Ключем является имя класса, а значением discriminatorValue, взятое из методанных
     *
     * @var array
     */
    protected $discriminatorValueMap = [];

    /**
     * DiscriminatorEntryListener constructor.
     *
     * @param Reader $reader
     *
     * @throws Exception\AnnotationReaderException
     */
    public function __construct(Reader $reader)
    {
        $this->setReader($reader);
        $this->init();
    }

    /**
     * @inheritdoc
     *
     * @return array
     */
    public function getSubscribedEvents()
    {
        return [
            Events::loadClassMetadata
        ];
    }

    /**
     * Иницилазия
     *
     * @return void
     * @throws Exception\AnnotationReaderException
     */
    protected function init()
    {
        try {
            AnnotationRegistry::registerLoader(function ($class) {
                return (bool) class_exists($class);
            });
        } catch (\Exception $e) {
            throw new Exception\AnnotationReaderException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param LoadClassMetadataEventArgs $eventArgs
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws Exception\DiscriminatorValueNotFoundException
     * @throws Exception\DuplicateDiscriminatorMapEntryException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function loadClassMetadata(LoadClassMetadataEventArgs $eventArgs)
    {
        $classMetadata = $eventArgs->getClassMetadata();
        if (!$classMetadata instanceof ClassMetadataInfo) {
            return;
        }

        //Сущность не участвует в цепочке наследования.
        if ($classMetadata->isInheritanceTypeNone()) {
            return;
        }


        if ($classMetadata->isRootEntity()) {
            $allClassNames = $this->getAllClassNamesByEntityManager($eventArgs->getEntityManager());
            $this->buildDiscriminatorMapRootEntity($classMetadata, $allClassNames);
        } else {
            $this->buildDiscriminatorMapChildEntity($classMetadata);
        }
    }

    /**
     * Собрать карту дескиминаторов для коренвой сущности
     *
     * @param ClassMetadataInfo $classMetadata
     * @param array             $allClassNames
     *
     * @throws Exception\DiscriminatorValueNotFoundException
     * @throws Exception\DuplicateDiscriminatorMapEntryException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function buildDiscriminatorMapRootEntity(ClassMetadataInfo $classMetadata, array $allClassNames = [])
    {
        foreach ($allClassNames as $className) {
            if (is_subclass_of($className, $classMetadata->name) && $this->hasDiscriminatorValue($className)) {
                $discriminatorValue = $this->getDiscriminatorValue($className);

                if (array_key_exists($discriminatorValue, $classMetadata->discriminatorMap)) {
                    $errMsg = sprintf('Found duplicate discriminator map entry \'%s\' in %s', $discriminatorValue,  $className);
                    throw new Exception\DuplicateDiscriminatorMapEntryException($errMsg);
                }
                $classMetadata->addDiscriminatorMapClass($discriminatorValue, $className);
            }
        }
    }

    /**
     * Добавляет в сущности потомке DiscriminatorMap. Вызов addDiscriminatorMapClass приводит к тому что проставляется
     * корректное значение discriminatorValue
     *
     * @param ClassMetadataInfo $classMetadata
     *
     * @throws Exception\DiscriminatorValueNotFoundException
     * @throws \Doctrine\ORM\Mapping\MappingException
     */
    public function buildDiscriminatorMapChildEntity(ClassMetadataInfo $classMetadata)
    {
        if ($this->hasDiscriminatorValue($classMetadata->name)) {
            $discriminatorValue = $this->getDiscriminatorValue($classMetadata->name);
            $classMetadata->addDiscriminatorMapClass($discriminatorValue, $classMetadata->name);
        }
    }

    /**
     * Получить список всех классов сущностей для заданного EntityManager'a
     *
     * @param EntityManagerInterface $em
     *
     * @return array
     *
     * @throws \Doctrine\ORM\ORMException
     */
    public function getAllClassNamesByEntityManager(EntityManagerInterface $em)
    {
        $hash = spl_object_hash($em);
        if (array_key_exists($hash, $this->entityManagerAllClassNames)) {
            return $this->entityManagerAllClassNames[$hash];
        }

        $this->entityManagerAllClassNames[$hash] = $em->getConfiguration()->getMetadataDriverImpl()->getAllClassNames();

        return $this->entityManagerAllClassNames[$hash];
    }

    /**
     * @param $className
     *
     * @return bool
     */
    public function hasDiscriminatorValue($className)
    {
        if (array_key_exists($className, $this->discriminatorValueMap)) {
            return false !== $this->discriminatorValueMap[$className];
        }
        $this->discriminatorValueMap[$className] = $this->buildDiscriminatorValueMap($className);

        return $this->discriminatorValueMap[$className];
    }

    /**
     * Получить значение discriminatorValue для класса
     *
     * @param $className
     *
     * @return string
     *
     * @throws Exception\DiscriminatorValueNotFoundException
     */
    public function getDiscriminatorValue($className)
    {
        if (!$this->hasDiscriminatorValue($className)) {
            $errMsg = sprintf('Discriminator value for %s not found', $className);
            throw new Exception\DiscriminatorValueNotFoundException($errMsg);
        }

        return $this->discriminatorValueMap[$className];
    }

    /**
     * По имени класса получает discriminatorValue
     *
     * @param $className
     *
     * @return bool|string
     */
    public function buildDiscriminatorValueMap($className)
    {
        $rClass = new ReflectionClass($className);

        /** @var DiscriminatorEntry|null $annotation */
        $annotation = $this->getReader()->getClassAnnotation($rClass, DiscriminatorEntry::class);

        if (null === $annotation) {
            return false;
        }

        return $annotation->value;
    }

    /**
     * Возвращает сервис для чтения метаданных
     *
     * @return Reader
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * Устанавливает сервис для чтения метаданных
     *
     * @param Reader $reader
     *
     * @return $this
     */
    public function setReader(Reader $reader)
    {
        $this->reader = $reader;

        return $this;
    }
}
