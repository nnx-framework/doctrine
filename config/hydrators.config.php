<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\Hydrator\DoctrineObjectHydratorAbstractFactory;

return [
    'hydrators' => [
        'abstract_factories' => [
            DoctrineObjectHydratorAbstractFactory::class => DoctrineObjectHydratorAbstractFactory::class,
        ]
    ],
];