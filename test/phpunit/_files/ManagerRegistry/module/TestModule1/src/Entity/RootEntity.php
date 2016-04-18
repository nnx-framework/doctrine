<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\ManagerRegistry\TestModule1\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class RootEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\ManagerRegistry\TestModule1\Entity
 *
 * @ORM\Entity()
 * @ORM\DiscriminatorMap()
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorMap(value={ "rootEntity" = "RootEntity" })
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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}