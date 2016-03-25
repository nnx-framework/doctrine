<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager\Exception;

use Nnx\Doctrine\Exception\InvalidArgumentException as BaseInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @package Nnx\Doctrine\ObjectManager\Exception
 */
class InvalidArgumentException extends BaseInvalidArgumentException implements
    ExceptionInterface
{
}
