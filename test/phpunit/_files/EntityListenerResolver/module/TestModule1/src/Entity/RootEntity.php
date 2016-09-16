<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RootEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Entity
 *
 * @ORM\Entity()
 * @ORM\DiscriminatorMap()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap(value={ "rootEntity" = "RootEntity" })
 * @ORM\EntityListeners({"Nnx\Doctrine\PhpUnit\TestData\EntityListenerResolver\TestModule1\Listener\RootEntityListener"})
 */
class RootEntity
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * Flag: listener changed entity
     *
     * @var bool
     */
    protected $listenerChanged = false;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isListenerChanged()
    {
        return $this->listenerChanged;
    }

    /**
     * @param boolean $listenerChanged
     *
     * @return $this
     */
    public function setListenerChanged($listenerChanged)
    {
        $this->listenerChanged = $listenerChanged;
        return $this;
    }
}
