<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TestEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity
 *
 * @ORM\Entity()
 */
class AssociatedEntity
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
     * @ORM\OneToOne(targetEntity="RootEntity")
     * @ORM\JoinColumn(name="test_entity_id", referencedColumnName="id")
     *
     * @var RootEntity
     */
    protected $associated;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return RootEntity
     */
    public function getAssociated()
    {
        return $this->associated;
    }

    /**
     * @param RootEntity $associated
     *
     * @return $this
     */
    public function setAssociated(RootEntity $associated)
    {
        $this->associated = $associated;

        return $this;
    }



}