<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @year    2016
 * @author  Lobanov Aleksandr <alex912004@gmail.com>
 */

namespace Nnx\Doctrine\Traits\Factory;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Nnx\Doctrine\EntityManager\EntityManagerInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerAutoDetectorInterface;

/**
 * Class ObjectManagerAwareTrait
 * @package Nnx\Doctrine\Traits\Factory
 */
trait ObjectManagerAwareTrait
{
    use ServiceManagerAwareTrait;

    /**
     * @return ObjectManager
     */
    protected function getObjectManager($class)
    {
        /** @var ObjectManagerAutoDetectorInterface $serviceAutoDetector */
        $serviceAutoDetector = $this->getServiceManager()->get(ObjectManagerAutoDetectorInterface::class);
        return $serviceAutoDetector->getObjectManagerByClassName($class);
    }

    /**
     * @param string $interface
     * @return string
     */
    protected function getEnityClass($interface)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getServiceManager()->get(EntityManagerInterface::class);
        return $em->getEntityClassByInterface($interface);
    }

    /**
     * @param string $interface
     * @return ObjectRepository
     */
    protected function getRepository($interface)
    {
        $entityManager = $this->getObjectManager($interface);
        $class = $this->getEnityClass($interface);
        return $entityManager->getRepository($class);
    }
}
