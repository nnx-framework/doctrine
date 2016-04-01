<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\EntityManager\EntityManager;
use Nnx\Doctrine\EntityManager\OrmEntityAbstractFactory;
use Nnx\Doctrine\EntityManager\EntityMapAbstractFactory;

return [
    EntityManager::CONFIG_KEY => [
        'invokables'         => [
            
        ],
        'factories'          => [

        ],
        'abstract_factories' => [
            OrmEntityAbstractFactory::class => OrmEntityAbstractFactory::class,
            EntityMapAbstractFactory::class => EntityMapAbstractFactory::class,
        ]
    ],
];


