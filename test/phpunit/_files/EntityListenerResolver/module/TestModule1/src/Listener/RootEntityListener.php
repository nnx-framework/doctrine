<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

namespace Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Listener;

use Doctrine\ORM\Event\PreFlushEventArgs;
use Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Entity\RootEntity;

/**
 * Class RootEntityListener
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Listener
 */
class RootEntityListener
{
    /**
     * @var bool
     */
    protected $fromContainer = false;

    /**
     * RootEntityListener constructor.
     *
     * @param $fromContainer
     */
    public function __construct($fromContainer)
    {
        $this->fromContainer = $fromContainer;
    }

    /**
     * @param RootEntity        $entity
     * @param PreFlushEventArgs $event
     */
    public function preFlush(RootEntity $entity, PreFlushEventArgs $event)
    {
        if ($this->fromContainer) {
            $entity->setListenerChanged(true);
        }
    }
}
