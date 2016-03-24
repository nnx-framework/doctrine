<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager\Exception;

use Nnx\Doctrine\Exception\InvalidArgumentException as BaseInvalidArgumentException;

/**
 * Class InvalidArgumentException
 *
 * @package Nnx\Doctrine\EntityManager\Exception
 */
class InvalidArgumentException extends BaseInvalidArgumentException implements
    ExceptionInterface
{
}
