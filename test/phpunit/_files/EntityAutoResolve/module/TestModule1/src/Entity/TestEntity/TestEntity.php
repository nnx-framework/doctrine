<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\TestEntity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class TestEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\TestEntity
 *
 * @ORM\Entity()
 * @ORM\Table(name="EntityAutoResolve_TestModule1_TestEntity")
 */
class TestEntity implements TestEntityInterface
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column()
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