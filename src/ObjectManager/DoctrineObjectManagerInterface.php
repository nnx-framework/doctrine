<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager;

use Interop\Container\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Interface DoctrineObjectManagerInterface
 *
 * @package Nnx\Doctrine\ObjectManager
 *
 * @method ObjectManager get($id)
 */
interface DoctrineObjectManagerInterface extends ContainerInterface
{
}
