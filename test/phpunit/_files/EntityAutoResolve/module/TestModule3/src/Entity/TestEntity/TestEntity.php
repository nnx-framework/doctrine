<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule3\Entity\TestEntity;

use Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule1\Entity\TestEntity\TestEntityInterface as RootTestEntityInterface;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\InitializableInterface;

/**
 * Class TestEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\EntityAutoResolve\TestModule3\Entity\TestEntity
 *
 * @ORM\Entity()
 */
class TestEntity implements TestEntityInterface, RootTestEntityInterface, InitializableInterface
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\Column()
     */
    protected $id;

    /**
     * Интерфейс \Zend\Stdlib\InitializableInterface, добавлен для проверки механизма генерации карты сущностей.
     * Необходимо убедиться что карта генерируется только для интерфейсов, располженных в тех же модулях, что и сами сущности.
     * Т.е. для \Zend\Stdlib\InitializableInterface не должно быть сгенерировано значение в карте сущностей.
     *
     * @return mixed
     */
    public function init()
    {

    }


}