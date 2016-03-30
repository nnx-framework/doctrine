<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\Overload;

use Doctrine\ORM\Mapping as ORM;
use Nnx\Doctrine\Annotation as NNXD;
use Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\RootEntity as BaseEntity;

/**
 * Class RootEntity
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Entity\Overload
 *
 * @ORM\Entity()
 * @NNXD\DiscriminatorEntry(value="overload")
 */
class RootEntity extends BaseEntity
{
    /**
     *
     * @ORM\Column(type="string")
     *
     * @var string
     */
    protected $testValue;

    /**
     * @return string
     */
    public function getTestValue()
    {
        return $this->testValue;
    }

    /**
     * @param string $testValue
     *
     * @return $this
     */
    public function setTestValue($testValue)
    {
        $this->testValue = $testValue;

        return $this;
    }

    

}