<?php
/**
 * @year    2016
 * @author  Lobanov Aleksandr <lobanov@mte-telecom.ru>
 */

return [
    'doctrine' => [
        'driver' => [
            'testModule1' => [
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity'],
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
            ],
        ]
    ]
];