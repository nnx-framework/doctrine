<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Options;

use Nnx\ModuleOptions\ModuleOptionsInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderInterface;
use Nnx\Doctrine\ObjectManager\ObjectManagerNameProviderTrait;
use Zend\Stdlib\AbstractOptions;

/**
 * Class ModuleOptions
 *
 * @package Nnx\Doctrine\PhpUnit\TestData\DiscriminatorEntry\TestModule1\Options
 */
class ModuleOptions extends AbstractOptions implements ModuleOptionsInterface, ObjectManagerNameProviderInterface
{
    use ObjectManagerNameProviderTrait;
}