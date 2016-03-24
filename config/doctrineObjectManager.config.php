<?php
/**
 * @link    https://github.com/nnx-company/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\ObjectManager\DoctrineObjectManager;
use Nnx\Doctrine\ObjectManager\OrmAbstractFactory;


return [
    DoctrineObjectManager::CONFIG_KEY => [
        'invokables'         => [
            
        ],
        'factories'          => [

        ],
        'abstract_factories' => [
            OrmAbstractFactory::class => OrmAbstractFactory::class
        ]
    ],
];


