<?php
/**
 * @link    https://github.com/nnx-framework/doctrine
 * @author  Malofeykin Andrey  <and-rey2@yandex.ru>
 */
namespace Nnx\Doctrine\PhpUnit\TestData\ObjectManagerAutoDetector;

use Nnx\Doctrine\PhpUnit\TestData\TestPaths;

return [
    'doctrine' => [
        'entitymanager' => [
            'test' => [
                'configuration' => 'test',
                'connection'    => 'test',
            ]
        ],
        'connection' => [
            'test' => [
                'configuration' => 'test',
                'eventmanager'  => 'orm_default',
            ]
        ],
        'configuration' => [
            'test' => [
                'metadata_cache'    => 'array',
                'query_cache'       => 'array',
                'result_cache'      => 'array',
                'hydration_cache'   => 'array',
                'driver'            => 'test',
                'generate_proxies'  => true,

                'proxy_dir'         => TestPaths::getPathToDoctrineProxyDir(),
                'proxy_namespace'   => 'DoctrineORMModule\Proxy',
                'filters'           => [],
                'datetime_functions' => [],
                'string_functions' => [],
                'numeric_functions' => [],
                'second_level_cache' => []
            ]
        ],
        'driver' => [
            'test' => [
                'class'   => 'Doctrine\ORM\Mapping\Driver\DriverChain',
                'drivers' => [
                    'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule3\\Entity' => 'testModule3',
                    'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule1\\Entity' => 'testModule1',
                    'Nnx\\Doctrine\\PhpUnit\\TestData\\ObjectManagerAutoDetector\\TestModule2\\Entity' => 'testModule2',
                ]
            ]
        ]
    ]
];