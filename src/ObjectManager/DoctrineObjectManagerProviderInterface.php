<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\ObjectManager;

/**
 * Interface DoctrineObjectManagerProviderInterface
 *
 * @package Nnx\Doctrine\ObjectManager
 */
interface DoctrineObjectManagerProviderInterface
{
    /**
     * @return array
     */
    public function getDoctrineObjectManagerConfig();
}
