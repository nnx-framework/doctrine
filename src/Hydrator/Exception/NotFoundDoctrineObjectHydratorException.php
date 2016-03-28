<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\Hydrator\Exception;

use Interop\Container\Exception\NotFoundException;

/**
 * Class NotFoundDoctrineObjectHydratorException
 *
 * @package Nnx\Doctrine\Hydrator\Exception
 */
class NotFoundDoctrineObjectHydratorException extends RuntimeException implements NotFoundException
{
}
