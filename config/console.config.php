<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine;

use Nnx\Doctrine\Controller\EntityMapBuilderController;

return [
    'console' => [
        'router' => [
            'routes' => [
                'entity-map-build' => [
                    'options' => [
                        'route'    => 'entity-map build --objectManager=',
                        'defaults' => [
                            'controller' => EntityMapBuilderController::class,
                            'action'     => 'build'
                        ]
                    ],
                ]
            ]
        ]
    ],
];