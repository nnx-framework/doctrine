<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule3\Entity\TestEntity;

use Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\TestEntity\TestEntityInterface as RootTestEntityInterface;

/**
 * Class TestEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule3\Entity\TestEntity
 */
class TestEntity implements TestEntityInterface, RootTestEntityInterface
{

}