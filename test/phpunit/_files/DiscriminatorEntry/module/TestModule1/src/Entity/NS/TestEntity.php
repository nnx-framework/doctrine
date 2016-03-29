<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\NS;

use Doctrine\ORM\Mapping as ORM;
use Nnx\Doctrine\Annotation as NNXD;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\TestEntity as RootEntity;

/**
 * Class TestEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\NS
 *
 * @ORM\Entity()
 * @NNXD\DiscriminatorEntry(value="test_discriminator")
 */
class TestEntity extends RootEntity
{

}