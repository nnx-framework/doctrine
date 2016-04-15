<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry\Exception;

use Nnx\Doctrine\Exception\InvalidArgumentException as BaseInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @package Nnx\Doctrine\ManagerRegistry\Exception
 */
class InvalidArgumentException extends BaseInvalidArgumentException implements
    ExceptionInterface
{
}
