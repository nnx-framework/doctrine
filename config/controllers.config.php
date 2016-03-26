<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\Controller\EntityMapBuilderController;
use Nnx\Doctrine\Controller\EntityMapBuilderControllerFactory;

return [
    'controllers' => [
        'factories' => [
            EntityMapBuilderController::class => EntityMapBuilderControllerFactory::class,
        ]
    ],
];