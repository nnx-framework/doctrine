<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\EntityManager;

/**
 * Interface EntityManagerProviderInterface
 *
 * @package Nnx\Doctrine\EntityManager
 */
interface EntityManagerProviderInterface
{
    /**
     * @return array
     */
    public function getEntityManagerConfig();
}
