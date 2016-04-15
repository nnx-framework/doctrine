<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ManagerRegistry\Exception;

use Nnx\Doctrine\Exception\DomainException as BaseDomainException;

/**
 * Class DomainException
 *
 * @package Nnx\Doctrine\ManagerRegistry\Exception
 */
class DomainException extends BaseDomainException implements
    ExceptionInterface
{
}
