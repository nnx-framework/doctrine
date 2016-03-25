<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;



/**
 * Class OrmAbstractFactory
 *
 * @package Nnx\Doctrine\EntityManager
 */
class OrmEntityLocator implements OrmEntityLocatorInterface
{

    /**
     * @var ObjectManagerAutoDetectorInterface
     */
    protected $objectManagerAutoDetector;

    /**
     * OrmEntityLocator constructor.
     *
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     */
    public function __construct(ObjectManagerAutoDetectorInterface $objectManagerAutoDetector)
    {
        $this->setObjectManagerAutoDetector($objectManagerAutoDetector);
    }


    /**
     * @inheritdoc
     *
     * @param string $id
     *
     * @return bool
     */
    public function get($id)
    {
        
    }

    /**
     * @inheritdoc
     *
     * @param string $id
     *
     * @return mixed
     */
    public function has($id)
    {
        $this->getObjectManagerAutoDetector()->getObjectManagerNameByClassName($id);
    }

    /**
     * @return ObjectManagerAutoDetectorInterface
     */
    public function getObjectManagerAutoDetector()
    {
        return $this->objectManagerAutoDetector;
    }

    /**
     * @param ObjectManagerAutoDetectorInterface $objectManagerAutoDetector
     *
     * @return $this
     */
    public function setObjectManagerAutoDetector($objectManagerAutoDetector)
    {
        $this->objectManagerAutoDetector = $objectManagerAutoDetector;

        return $this;
    }
}
