<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\DiscriminatorEntry\Exception;

use Nnx\Doctrine\Exception\InvalidArgumentException as BaseInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @package Nnx\Doctrine\DiscriminatorEntry\Exception
 */
class InvalidArgumentException extends BaseInvalidArgumentException implements
    ExceptionInterface
{
}
