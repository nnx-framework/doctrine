<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector\TestModule2\Entity\TestEntity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Class TestEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector\TestModule2\Entity\TestEntity
 *
 * @ORM\Entity()
 */
class TestEntity implements TestEntityInterface
{
    /**
     * @var integer
     * @ORM\Id()
     * @ORM\Column()
     */
    protected $id;
}